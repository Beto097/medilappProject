@extends('plantilla.plantillaDT')

@section('titulo')
   Ordenes de Laboratorio
@endsection

@section('css')
    
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todas las ordenes de laboratorio en el sistema.</p>
        </div>
        <div class="col-sm-2">
            
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
                                            <th>Id</th>
                                            <th>Paciente</th>
                                            <th>Cedula</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th class="text-center">Nº de Examenes</th>                                                          
                                            <th>Acciones</th>   
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td scope="row">{{ $fila->id }}</td>
                                                <td>{{ $fila->paciente->nombre_paciente}} {{ $fila->paciente->apellido_paciente}}</td>
                                                <td>{{ $fila->paciente->identificacion_paciente}}</td>
                                                <td>{{$fila->fecha_orden}}</td>
                                                <td>
                                                    @if ($fila->estado_orden_laboratorio == 'Pendiente')
                                                        <span class="label label-danger">{{ $fila->estado_orden_laboratorio}}</span>
                                                    @elseif($fila->estado_orden_laboratorio == 'En Proceso')
                                                        <span class="label label-warning">{{ $fila->estado_orden_laboratorio}}</span>
                                                    @else
                                                        <span class="label label-success">{{ $fila->estado_orden_laboratorio}}</span>
                                                    @endif    
                                                    
                                                </td>
                                                <td class="text-center">
                                                    {{count($fila->examen_orden_laboratorio)}}
                                                    
                                                </td>
                                                <td>                                                   
                                                        <a class="btn btn-primary btn-sm" title="Ver detalles" href="{{ route('ordenLaboratorio.examenes', ['id' => $fila->id]) }}" class=""><i  class="fa fa-eye"></i></a>
                                                    
                                                                                       
                                                </td>  
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>Id</th>
                                            <th>Paciente</th>
                                            <th>Cedula</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th class="text-center">Nº de Examenes</th>                                                          
                                            <th>Acciones</th>   
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
      { "width": "10%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection 

