<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\pantalla;
use App\Models\rol_pantalla;

echo "=== Verificando rutas relacionadas con receta ===\n";

// Buscar pantallas relacionadas con receta
$pantallas_receta = pantalla::where('url_pantalla', 'like', '%receta%')->get();

echo "Pantallas con 'receta' en la URL:\n";
foreach($pantallas_receta as $pantalla) {
    echo "- ID: {$pantalla->id}, URL: {$pantalla->url_pantalla}, Nombre: {$pantalla->nombre_pantalla}\n";
}

echo "\n=== Verificando pantalla específica '/receta/imprimir' ===\n";
$pantalla_imprimir = pantalla::where('url_pantalla', '/receta/imprimir')->first();
if($pantalla_imprimir) {
    echo "Pantalla encontrada: ID {$pantalla_imprimir->id}, URL: {$pantalla_imprimir->url_pantalla}\n";
    
    // Buscar roles que tienen acceso a esta pantalla
    $roles_con_acceso = rol_pantalla::where('pantalla_id', $pantalla_imprimir->id)->with('rol')->get();
    
    echo "Roles que tienen acceso:\n";
    foreach($roles_con_acceso as $rol_pantalla) {
        echo "- Rol: {$rol_pantalla->rol->name} (ID: {$rol_pantalla->rol_id})\n";
    }
} else {
    echo "Pantalla '/receta/imprimir' NO encontrada\n";
}

echo "\n=== Creando pantalla '/receta/imprimir' si no existe ===\n";
if(!$pantalla_imprimir) {
    $nueva_pantalla = pantalla::create([
        'url_pantalla' => '/receta/imprimir',
        'nombre_pantalla' => 'Imprimir Receta',
        'icono_pantalla' => 'fa-print'
    ]);
    echo "Pantalla creada con ID: {$nueva_pantalla->id}\n";
    
    // Asignar a rol admin (asumiendo que existe rol con ID 1)
    rol_pantalla::create([
        'rol_id' => 1,
        'pantalla_id' => $nueva_pantalla->id
    ]);
    echo "Permiso asignado al rol ID 1\n";
}

echo "\n=== Script completado ===\n";
