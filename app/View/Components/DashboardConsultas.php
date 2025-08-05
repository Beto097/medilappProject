<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\consulta;

use Carbon\Carbon;

class DashboardConsultas extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $consultas;
    public $consultasD;
    
    public function __construct()
    {
        $this->consultas = consulta::whereIn('estado_consulta', ['TERMINADA', 'CERRADA', 'EN CURSO', 'PENDIENTE'])
                                        ->where('fecha_consulta','>',Carbon::today()->subMonth(1)->toDateString())
                                        ->groupBy('medico_id')
                                        ->selectRaw('count(*) as total, medico_id')
                                        ->get();

        $this->consultasD = consulta::whereIn('estado_consulta', ['TERMINADA', 'CERRADA', 'EN CURSO', 'PENDIENTE'])
                                        ->whereBetween('created_at', [
                                            Carbon::now('America/Panama')->startOfDay(),
                                            Carbon::now('America/Panama')->endOfDay()
                                        ])
                                        ->groupBy('medico_id')
                                        ->selectRaw('count(*) as total, medico_id')
                                        ->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-consultas');
    }
}
