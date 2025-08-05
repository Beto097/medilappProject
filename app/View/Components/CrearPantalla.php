<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\pantalla;

class CrearPantalla extends Component
{
    /**
     * Create a new component instance.
     */

    public $pantallas;

    public function __construct()
    {
        $this->pantallas = pantalla::where('padre',0)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.crear-pantalla');
    }
}
