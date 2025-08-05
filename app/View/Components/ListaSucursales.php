<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\sucursal;

class ListaSucursales extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $sucursales;
    public function __construct()
    {
        $this->sucursales = sucursal::where('estado_sucursal','1')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lista-sucursales');
    }
}
