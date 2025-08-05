<div class="form-group col-md-6">
    <label for="">Nombre del Archivo</label>
    <input type="text" class="form-control" id="txtNombre_{{$paciente_id}}" placeholder="Ejemplo: Crear Usuario"  value="{{old('txtNombre')}}" name="txtNombre" required>
</div>                                                                     
<div class="form-group col-md-6">
    
    <label for="">Archivo</label>
    <input type="file" class="form-control" id="archivo_{{$paciente_id}}" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.bmp,.webp" name="archivo" aria-describedby="inputGroupFileAddon04" required>
            
        
</div>

<div class="modal-footer">  
    <input type="hidden" name="txtId" id="txtId_{{$paciente_id}}" class="form-control form-control-sm" value="{{$paciente_id}}">                                      
    <button type="submit" id="btnSubirArchivo_{{$paciente_id}}" class="btn btn-primary text-left">Subir</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Buscar el formulario que contiene este componente
    const submitBtn = document.getElementById('btnSubirArchivo_{{$paciente_id}}');
    
    if (submitBtn) {
        const form = submitBtn.closest('form');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                const nombre = document.getElementById('txtNombre_{{$paciente_id}}').value.trim();
                const archivo = document.getElementById('archivo_{{$paciente_id}}').files[0];
                const pacienteId = document.getElementById('txtId_{{$paciente_id}}').value;
                
                if (!nombre) {
                    e.preventDefault();
                    alert('Por favor ingresa un nombre para el archivo');
                    return false;
                }
                
                if (!archivo) {
                    e.preventDefault();
                    alert('Por favor selecciona un archivo');
                    return false;
                }
                
                if (archivo.size > 209715200) { // 200MB en bytes
                    e.preventDefault();
                    alert('El archivo es muy grande. El tamaño máximo permitido es 200MB.');
                    return false;
                }
                
                if (!pacienteId) {
                    e.preventDefault();
                    alert('Error: No se pudo identificar el paciente');
                    return false;
                }
                
                // Mostrar mensaje específico según el tamaño del archivo
                const tamañoMB = (archivo.size / 1024 / 1024).toFixed(1);
                let mensaje = 'Subiendo...';
                
                if (archivo.size > 50 * 1024 * 1024) { // > 50MB
                    mensaje = `Subiendo archivo grande (${tamañoMB}MB)... Esto puede tomar varios minutos.`;
                } else if (archivo.size > 10 * 1024 * 1024) { // 10-50MB
                    mensaje = `Subiendo archivo (${tamañoMB}MB)... Por favor espere.`;
                } else if (archivo.size > 5 * 1024 * 1024) { // 5-10MB
                    mensaje = `Subiendo y optimizando (${tamañoMB}MB)...`;
                }
                
                // Deshabilitar el botón para evitar doble envío
                submitBtn.disabled = true;
                submitBtn.textContent = mensaje;
                
                return true;
            });
        }
    }
});
</script>