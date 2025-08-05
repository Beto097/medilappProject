
{{-- filepath: resources/views/partials/paciente_acciones.blade.php --}}
@if (Auth::user()->accesoRuta('/consulta/create'))  
    <button type="button" title="Crear Consulta" class="@if ($fila->consultaActiva()) btn btn-warning btn-sm btnIcono disabled @else btn btn-primary btn-sm btnIcono @endif" id="crearConsulta"                
        data-toggle="modal" data-target="#crearConsultaDoctorModal{{$fila->id}}" onclick="this.classList.add('disabled'); this.style.pointerEvents='none';">
        <i id="iconoBoton" class="@if ($fila->consultaActiva()) fa fa-clock-o @else fa fa-file @endif"></i>
    </button>
    @if (!$fila->consultaActiva())
        @include('modals.CrearConsultaDoctorModals')
    @endif    
@endif 

@if (Auth::user()->accesoRuta('/paciente/historia/clinica'))
    <a class="btn btn-info btn-sm btnIcono" title="ver Historial" href="{{route('paciente.verHistorial', ['id'=> $fila->id] )}}" class=""><i id="iconoBoton" class="fa fa-files-o"></i></a>
@endif  

@if (Auth::user()->accesoRuta('/paciente/update')) 
    <button type="button" class="btn btn-success btn-sm btnIcono " id="editPaciente"                
        data-toggle="modal" data-target="#editarPacienteModal{{$fila->id}}">
        <i class="fa fa-edit"></i>
    </button>
    @include('modals.editarPacienteModals')
@endif

@if (Auth::user()->accesoRuta('/paciente/delete')) 
    @if($fila->estado_paciente == 1)
        <a class="btn btn-danger btn-sm btnIcono" title="Eliminar paciente" href="{{route('paciente.delete', ['id'=> $fila->id] )}}" onclick="
        return confirm('Desea eliminar este paciente del sistema?')"><i class="fa fa-trash-o"></i></a>
    @else
        <a class="btn btn-warning btn-sm btnIcono" title="Desbloquear paciente" href="{{route('paciente.desbloquear', ['id'=> $fila->id] )}}" onclick="
        return confirm('Desea desbloquear este paciente del sistema?')"><i class="fa fa-unlock-alt"></i></a>
    @endif 
@endif