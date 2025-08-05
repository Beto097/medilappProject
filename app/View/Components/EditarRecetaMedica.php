<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\receta;

class EditarRecetaMedica extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $consulta;
    public $tipo;
    public $medicamentos;

    public function __construct($resultado , $modo = 'normal')
    {
        $this->consulta =$resultado;
        if($modo == 'imprimir'){
            $this->tipo = $modo;
        }
        $this->medicamentos = Receta::select('medicamento')->orderBy('medicamento')->distinct()->pluck('medicamento');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.editar-receta-medica');
    }
}
