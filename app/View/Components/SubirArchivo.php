<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubirArchivo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $paciente_id;
    public function __construct($id)
    {
        $this->paciente_id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subir-archivo');
    }
}
