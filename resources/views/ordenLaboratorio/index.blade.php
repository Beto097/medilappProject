@extends('plantilla.plantillaDT')
@section('titulo')
    Ordenes de Laboratorio
@endsection


@section('contenido')

<div class="row">
    <br>
    <div class="col-md-10">
        <p>Este listado muestra todos las Ordenes de Laboratorio que se encuentran el la institución.</p>
    </div>
    <div class="col-md-2">
        @if(Auth::user()->permisos('orden_laboratorio','create'))
            <a href="{{ route('orden_laboratorio.create') }}" class="btn btn-primary btn-lable-wrap left-label">
                <span class="btn-label"><i class="fa fa-folder-o"></i> 
                </span>
                <span class="btn-text">
                    Crear Nueva Orden
                </span>
            </a> 
        @endif
    </div>
    <br>
    <br>
    <br>
    @include('plantilla.errores')
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Ordenes de Laboratorio</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="datable_1" class="table table-hover display  pb-30" cellspacing="0"  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha Orden</th>
                                        <th>Cédula</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($resultado as $fila)
                                    <tr>
                                        <td scope="row">{{$fila->id}}</td>
                                        <td>{{$fila->fecha_orden}}</td>
                                        <td>{{$fila->paciente->identificacion_paciente}}</td>
                                        <td>{{$fila->paciente->nombre_paciente}} {{$fila->paciente->apellido_paciente}}</td>
                                        <td>
                                            @if ($fila->estado_orden_laboratorio=='Terminado')
                                                <span class="label label-success">{{$fila->estado_orden_laboratorio}}</span>
                                            @elseif($fila->estado_orden_laboratorio=='Eliminado')
                                                <span class="label label-danger">{{$fila->estado_orden_laboratorio}}</span>
                                            @elseif($fila->estado_orden_laboratorio=='Pendiente')
                                                <span class="label label-primary">{{$fila->estado_orden_laboratorio}}</span>
                                            @else
                                                <span class="label label-warning">{{$fila->estado_orden_laboratorio}}</span>
                                            @endif
                                        </td>
                                        <td>{{$fila->medico->nombre_medico}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" title="Orden Cliente" href="{{ route('imprimir.orden', ['id' => $fila->id]) }}" ><i id="iconoBoton" class="fa fa-file"></i></a>
                                            @if(Auth::user()->permisos('orden_laboratorio','update'))
                                                
                                                @if($fila->estado_orden_laboratorio == "Pendiente")
                                                    <a class="btn btn-success btn-sm" title="Modificar orden" href="{{ route('orden_laboratorio.update', ['id' => $fila->id]) }}"><i id="iconoBoton" class="fa fa-edit"></i></a>
                                                                                    
                                                @endif
                                                
                                            
                                            @endif
                                            @if(Auth::user()->permisos('orden_laboratorio','delete'))
                                                
                                                @if($fila->estado_orden_laboratorio == "Pendiente")                                            
                                                    <a class="btn btn-danger btn-sm" title="Eliminar orden" href="{{ route('orden_laboratorio.delete', ['id' => $fila->id]) }}" onclick="
                                                        return confirm('Desea eliminar esta orden del sistema?')"><i id="iconoBoton" class="fa fa-trash"></i></a>
                                                @endif
                                                @if($fila->estado_orden_laboratorio == "Eliminado")
                                                    <a class="btn btn-warning btn-sm" title="Restablecer orden" href="{{ route('orden_laboratorio.desbloquear', ['id' => $fila->id]) }}" onclick="
                                                        return confirm('Desea restablecer esta orden al sistema?')"><i id="iconoBotonW" class="fa fa-unlock"></i></a>
                                                @endif                                           
                                               
                                            @endif
                                            @if(Auth::user()->permisos('orden_laboratorio','ver'))
                                                
                                                @if($fila->estado_orden_laboratorio == "En Proceso" or $fila->estado_orden_laboratorio == "Terminado")
                                                    <a class="btn btn-success btn-sm" title="Ver orden" href="{{route('ordenLaboratorio.examenes',['id' => $fila->id])}}" class=""><i id="iconoBotn" class="fa fa-eye"></i></a>
                                                @endif                                           
                                                
                                            @endif          
                                        
                                        </td>
                                    </tr>
    
                                @endforeach
                                   
                                </tbody>
                            
                                <tfoot>
                                    <tr>                                                                                   
                                        <th>ID</th>
                                        <th>Fecha Orden</th>
                                        <th>Cédula</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Opciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
    </div>

</div>




  
@endsection

@section('ordenarTabla')

    ,"order": [[0,'desc']]
     ,"columns": [
      null,
      null,
      null,
      null,
      null,
      null,     
      { "width": "15%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection