<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\receta;

class RecetaMedica extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $consulta;
    public $medicamentos;


    public function __construct($resultado)
    {
        $this->consulta =$resultado;
        $this->medicamentos = Receta::select('medicamento')->orderBy('medicamento')->distinct()->pluck('medicamento');
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.receta-medica');
    }
}
