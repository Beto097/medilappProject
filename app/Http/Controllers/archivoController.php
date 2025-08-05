<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\archivo;
use App\Models\paciente;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class archivoController extends Controller
{
    public function insert(Request $request){

        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }
        
        if(Auth::user()->accesoRuta('/archivo/insertar')){

            // Incrementar tiempo de ejecución para archivos grandes
            set_time_limit(300); // 5 minutos
            ini_set('memory_limit', '512M');

            try {
                $request->validate([            
                    'archivo' => 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,bmp,webp|max:204800', // 200MB en KB (200*1024)
                    'txtNombre' => 'required|string|max:255',
                    'txtId' => 'required|integer'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()->withErrors(['danger' => "Error en validación: " . json_encode($e->errors())]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['danger' => "Error en validación: " . $e->getMessage()]);
            }
    
            // Obtener el archivo
            $file = $request->file('archivo');
    
            // Obtener fecha actual para crear carpeta por año/mes
            $fecha = Carbon::now();
            $rutaCarpeta = 'archivos/' . $fecha->format('Y') . '/' . $fecha->format('m');
            
            // Crear directorio si no existe
            if (!File::exists(public_path($rutaCarpeta))) {
                File::makeDirectory(public_path($rutaCarpeta), 0755, true);
            }
            
            // Obtener extensión del archivo
            $extension = $file->getClientOriginalExtension();
    
            // Crear nombre del archivo a guardar
            $nombreArchivo = Str::slug($request->txtNombre) . '_' . $fecha->format('Y-m-d-H-i-s') . '.' . $extension;
            
            $rutaCompleta = public_path($rutaCarpeta . '/' . $nombreArchivo);
    
            // Optimizar según el tipo de archivo
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                // Optimizar imágenes
                $this->optimizarImagen($file, $rutaCompleta, $extension);
            } else {
                // Para archivos que no son imágenes (PDF, DOC, etc.)
                $file->move(public_path($rutaCarpeta), $nombreArchivo);
                
                // Si es PDF y es mayor a 5MB, intentar optimizar
                if (strtolower($extension) === 'pdf' && filesize($rutaCompleta) > 5 * 1024 * 1024) { // 5MB
                    $this->optimizarPDF($rutaCompleta);
                }
            }
            
            // Guardar datos en base de datos
            $archivo = new archivo();
            $archivo->paciente_id = $request->txtId;
            $archivo->nombre = $request->txtNombre;
            $archivo->ruta = $rutaCarpeta . '/' . $nombreArchivo; // guarda la ruta relativa (útil para mostrar)        
            $archivo->save();
    
            return redirect()->back()->withErrors(['status' => "Se subio el archivo correctamente" ]);
        
        } else {
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            
        }            

        
    }

    public function verArchivos($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }
        
        if(Auth::user()->accesoRuta('/archivo/ver')){

            
            $paciente = paciente::find($id);         
    
            return view ("archivo.index",["paciente"=>$paciente]);
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            

        
    }

    public function delete($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }
        
        if(Auth::user()->accesoRuta('/archivo/delete')){

            $archivo = archivo::find($id);

            // Ruta absoluta del archivo físico
            $rutaArchivo = public_path($archivo->ruta);

            // Verificar y eliminar el archivo
            if (File::exists($rutaArchivo)) {
                File::delete($rutaArchivo);
            }

            // Eliminar el registro de la base de datos
            $archivo->delete();

            return redirect()->back()->withErrors(['status' => "Se elimino el archivo correctamente" ]);
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            

    
    }

    /**
     * Optimizar imágenes según su tamaño y tipo
     */
    private function optimizarImagen($file, $rutaDestino, $extension)
    {
        try {
            // Crear el manager de imágenes con el driver GD
            $manager = new ImageManager(new Driver());
            
            // Cargar la imagen
            $imagen = $manager->read($file->path());
            
            // Obtener dimensiones originales
            $ancho = $imagen->width();
            $alto = $imagen->height();
            $tamañoOriginal = $file->getSize();
            
            // Determinar nivel de optimización según el tamaño del archivo
            if ($tamañoOriginal > 10 * 1024 * 1024) { // > 10MB - optimización agresiva
                // Redimensionar a máximo 1920px
                if ($ancho > 1920 || $alto > 1920) {
                    $imagen = $imagen->scale(1920, 1920);
                }
                $calidad = 70; // Calidad baja para mayor compresión
                
            } elseif ($tamañoOriginal > 5 * 1024 * 1024) { // 5-10MB - optimización media
                // Redimensionar a máximo 2560px
                if ($ancho > 2560 || $alto > 2560) {
                    $imagen = $imagen->scale(2560, 2560);
                }
                $calidad = 75; // Calidad media
                
            } elseif ($tamañoOriginal > 2 * 1024 * 1024) { // 2-5MB - optimización suave
                // Redimensionar si es muy grande
                if ($ancho > 3200 || $alto > 3200) {
                    $imagen = $imagen->scale(3200, 3200);
                }
                $calidad = 80; // Calidad buena
                
            } else { // < 2MB - optimización mínima
                // Solo redimensionar si es excesivamente grande
                if ($ancho > 4000 || $alto > 4000) {
                    $imagen = $imagen->scale(4000, 4000);
                }
                $calidad = 85; // Calidad alta
            }
            
            // Ajustar calidad según el tipo de imagen
            if (strtolower($extension) === 'jpg' || strtolower($extension) === 'jpeg') {
                $calidad -= 5; // JPEG puede usar menos calidad
            } elseif (strtolower($extension) === 'png') {
                $calidad += 5; // PNG necesita más calidad
                $calidad = min($calidad, 95); // Máximo 95 para PNG
            }
            
            // Guardar la imagen optimizada
            if (strtolower($extension) === 'jpg' || strtolower($extension) === 'jpeg') {
                $imagen->toJpeg($calidad)->save($rutaDestino);
            } elseif (strtolower($extension) === 'png') {
                $imagen->toPng()->save($rutaDestino);
            } elseif (strtolower($extension) === 'webp') {
                $imagen->toWebp($calidad)->save($rutaDestino);
            } else {
                // Para otros formatos, usar el formato original
                $imagen->save($rutaDestino);
            }
            
            // Log del resultado de optimización
            $tamañoFinal = filesize($rutaDestino);
            $reduccion = round((($tamañoOriginal - $tamañoFinal) / $tamañoOriginal) * 100, 1);
            \Log::info("Imagen optimizada: {$this->formatearTamaño($tamañoOriginal)} → {$this->formatearTamaño($tamañoFinal)} ({$reduccion}% reducción)");
            
        } catch (\Exception $e) {
            // Si falla la optimización, guardar el archivo original
            \Log::warning('Error optimizando imagen: ' . $e->getMessage());
            $file->move(dirname($rutaDestino), basename($rutaDestino));
        }
    }

    /**
     * Optimizar PDFs según su tamaño
     */
    private function optimizarPDF($rutaArchivo)
    {
        try {
            $tamañoOriginal = filesize($rutaArchivo);
            
            // Verificar si Ghostscript está disponible
            $gsCommand = 'gs';
            
            // En Windows podría ser diferente
            if (PHP_OS_FAMILY === 'Windows') {
                $gsCommand = 'gswin64c'; // o gswin32c para 32 bits
            }
            
            $archivoTemporal = $rutaArchivo . '_temp.pdf';
            
            // Determinar nivel de compresión según el tamaño
            $configuracion = '/ebook'; // Por defecto
            if ($tamañoOriginal > 20 * 1024 * 1024) { // > 20MB
                $configuracion = '/screen'; // Compresión máxima
            } elseif ($tamañoOriginal > 10 * 1024 * 1024) { // 10-20MB
                $configuracion = '/ebook'; // Compresión alta
            } else { // < 10MB
                $configuracion = '/printer'; // Compresión media
            }
            
            // Comando para optimizar PDF con Ghostscript
            $comando = sprintf(
                '%s -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=%s -dNOPAUSE -dQUIET -dBATCH -dDownsampleColorImages=true -dColorImageResolution=150 -dDownsampleGrayImages=true -dGrayImageResolution=150 -dDownsampleMonoImages=true -dMonoImageResolution=150 -sOutputFile="%s" "%s"',
                $gsCommand,
                $configuracion,
                $archivoTemporal,
                $rutaArchivo
            );
            
            exec($comando, $output, $returnCode);
            
            // Si la optimización fue exitosa, reemplazar el archivo original
            if ($returnCode === 0 && file_exists($archivoTemporal)) {
                $tamañoOptimizado = filesize($archivoTemporal);
                
                // Reemplazar si hay alguna reducción de tamaño
                if ($tamañoOptimizado < $tamañoOriginal && $tamañoOptimizado > 0) {
                    unlink($rutaArchivo);
                    rename($archivoTemporal, $rutaArchivo);
                    
                    $reduccion = round((($tamañoOriginal - $tamañoOptimizado) / $tamañoOriginal) * 100, 1);
                    \Log::info("PDF optimizado: {$this->formatearTamaño($tamañoOriginal)} → {$this->formatearTamaño($tamañoOptimizado)} ({$reduccion}% reducción)");
                } else {
                    // Si no hay mejora, mantener original
                    unlink($archivoTemporal);
                    \Log::info("PDF no optimizado: no hubo reducción significativa de tamaño");
                }
            } else {
                // Si falla, eliminar archivo temporal si existe
                if (file_exists($archivoTemporal)) {
                    unlink($archivoTemporal);
                }
                \Log::warning("Optimización PDF falló: Ghostscript no disponible o error en ejecución");
            }
            
        } catch (\Exception $e) {
            // Si falla la optimización, mantener el archivo original
            \Log::warning('Error optimizando PDF: ' . $e->getMessage());
        }
    }

    /**
     * Obtener el tamaño de archivo en formato legible
     */
    private function formatearTamaño($bytes)
    {
        $units = array('B', 'KB', 'MB', 'GB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Obtener mensaje de error de upload
     */
    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_OK:
                return 'No error';
            case UPLOAD_ERR_INI_SIZE:
                return 'File exceeds upload_max_filesize';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File exceeds MAX_FILE_SIZE';
            case UPLOAD_ERR_PARTIAL:
                return 'File only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload';
            default:
                return 'Unknown error';
        }
    }
}
