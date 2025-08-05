<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrearReferencia extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $consulta;

    public function __construct($resultado)
    {
        $this->consulta = $resultado;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.crear-referencia');
    }
}
