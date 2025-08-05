<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListaEspecialidades extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $especialidades;  
    public function __construct()
    {
        $this->especialidades = json_decode(file_get_contents(storage_path('app/especialidades_agrupadas.json')), true);
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lista-especialidades');
    }
}
