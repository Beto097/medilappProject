<?php

use Illuminate\Support\Facades\DB;

// Verificar conexión a la base de datos
try {
    $pantallas = DB::table('pantalla')->where('url_pantalla', 'like', '%receta%')->get();
    
    echo "=== Pantallas relacionadas con receta ===\n";
    foreach($pantallas as $pantalla) {
        echo "ID: {$pantalla->id}, URL: {$pantalla->url_pantalla}, Nombre: {$pantalla->nombre_pantalla}\n";
    }
    
    // Verificar si existe la pantalla /receta/imprimir
    $pantalla_imprimir = DB::table('pantalla')->where('url_pantalla', '/receta/imprimir')->first();
    
    if(!$pantalla_imprimir) {
        echo "\n=== Creando pantalla /receta/imprimir ===\n";
        $pantalla_id = DB::table('pantalla')->insertGetId([
            'url_pantalla' => '/receta/imprimir',
            'nombre_pantalla' => 'Imprimir Receta',
            'icono_pantalla' => 'fa-print'
        ]);
        
        echo "Pantalla creada con ID: {$pantalla_id}\n";
        
        // Asignar al primer rol disponible
        $primer_rol = DB::table('rol')->first();
        if($primer_rol) {
            DB::table('rol_pantalla')->insert([
                'rol_id' => $primer_rol->id,
                'pantalla_id' => $pantalla_id
            ]);
            echo "Permiso asignado al rol: {$primer_rol->name}\n";
        }
    } else {
        echo "\nPantalla /receta/imprimir ya existe con ID: {$pantalla_imprimir->id}\n";
    }
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
