<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\rol;

class EditarRol extends Component
{
    /**
     * Create a new component instance.
     */

    public $fila;

    public function __construct($resultado)
    {
        $this->fila = $resultado;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.editar-rol');
    }
}
