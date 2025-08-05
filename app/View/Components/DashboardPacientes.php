<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Models\consulta;
use App\Models\paciente;

use Carbon\Carbon;

class DashboardPacientes extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $nuevos_pacientes;
    public $consultas_totales;
    public $consultas_mes;
    public $total_pacientes;
    public $hora; // Variable para la hora actual
    

    
    public function __construct()
    {
        $this->nuevos_pacientes = paciente::whereBetween('created_at', [Carbon::now('America/Panama')->startOfDay(), Carbon::now('America/Panama')->endOfDay()])->count();
        $this->total_pacientes = paciente::where('estado_paciente',1)->count();
        $this->consultas_mes = consulta::whereIn('estado_consulta', ['TERMINADA', 'CERRADA', 'EN CURSO', 'PENDIENTE'])
                ->whereBetween('created_at', [Carbon::now('America/Panama')->startOfDay(), Carbon::now('America/Panama')->endOfDay()])
                ->count();
        $this->consultas_totales = consulta::where('estado_consulta','CERRADA')->count();
        $this->hora= Carbon::now('America/Panama')->format('H:i:s'); // Hora actual para usar en la vista si es necesario

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-pacientes');
    }
}
