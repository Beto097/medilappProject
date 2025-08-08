<?php

use App\Models\ordenlaboratorio;

Route::get('/debug-table', function() {
    try {
        // Intentar obtener un registro para ver las columnas
        $orden = ordenlaboratorio::first();
        
        if ($orden) {
            echo "Columnas disponibles en la tabla ordenlaboratorio:<br>";
            foreach ($orden->getAttributes() as $key => $value) {
                echo "- {$key}: {$value}<br>";
            }
        } else {
            echo "No hay registros en la tabla ordenlaboratorio<br>";
        }
        
        // Intentar obtener la estructura de la tabla
        echo "<br>Estructura de la tabla:<br>";
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('ordenlaboratorio');
        foreach ($columns as $column) {
            echo "- {$column}<br>";
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
});
