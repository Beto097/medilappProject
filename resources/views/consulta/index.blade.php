@extends('plantilla.plantillaDT')

@section('titulo')
    Consultas
@endsection


@section('css')    

    @include('scripts.consulta')
    
    <style>
        /* Estilos para mejorar la presentación de la tabla */
        .btnIcono {
            margin: 1px;
            padding: 5px 8px;
        }
        
        td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }
        
        /* Permitir que la columna de acciones tenga contenido más flexible */
        td:last-child {
            white-space: normal;
            max-width: none;
        }
        
        /* Hacer los botones más compactos */
        .btn-sm {
            padding: 4px 8px;
            margin: 1px;
            font-size: 11px;
        }
    </style>
    
@endsection
@section('script')    

    @if(Auth::check() && !Auth::user()->accesoRuta('/recepcion/insertar'))
        @include('scripts.refrescar')
    @endif

@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todas las consultas que estan registradas en el sistema para la gestión de atención al paciente de este turno.</p>
        </div>
        <div class="col-sm-2">
          @if(Auth::user()->accesoRuta('/consulta/create'))
            <button class="btn btn-primary btn-lable-wrap left-label" id="addNewConsulta" data-toggle="modal" data-target="#addNewConsultaModal"> 
              <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                Agregar Consulta
              </span>
            </button>
            @include('modals.ConsultaModals')  
             
          @endif

        </div>
        <br>
        <br>
        <br>
            <div class="col-sm-4 col-sm-offset-8">
          @include('plantilla.errores')
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">
                        @if(Auth::user()->accesoRuta('/consulta/create'))
                          Listado de consultas del día
                        @else
                          Consultas para el Médico {{Auth::user()->primer_nombre_usuario}} {{Auth::user()->apellido_usuario}}</h6>
                        @endif
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
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th>Sexo</th>
                                        <th>Edad</th>
                                        <th>Tiempo</th>                            
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Motivo</th>
                                        <th>Acciones</th>
                                      </tr>
                                      
                                    </thead>
                                    
                                    <tbody>
                                      @foreach ($resultado as $key=>$fila)
                                        <tr style="font-size: 100%;">
                                          <td>{{$key+1}}</td>
                                          <td>{{$fila->paciente->identificacion_paciente}}</td>
                                          <td>{{$fila->paciente->nombre_paciente}} {{$fila->paciente->apellido_paciente}}</td>
                                          <td>@if($fila->paciente->sexo_paciente=="m")M @else F @endif</td>
                                          <td>
                                            {{$fila->paciente->edad()}}
                                          </td>
                                          <td>
                                            @php
                                              $diff = \Carbon\Carbon::parse($fila->created_at)->diffInMinutes(now());
                                              if ($diff < 1) {
                                                echo 'Ahora';
                                              } elseif ($diff < 60) {
                                                echo $diff . ' min';
                                              } elseif ($diff < 1440) {
                                                echo floor($diff / 60) . ' hor';
                                              } else {
                                                echo floor($diff / 1440) . ' días';
                                              }
                                            @endphp
                                          </td>   
                                          <td><p>{{$fila->estado_consulta}}</p></td>
                                          <td>{{$fila->doctor->primer_nombre_usuario}} {{$fila->doctor->apellido_usuario}}</td>
                                          <td>{{$fila->motivo_consulta}}</td>
                                          <td>
                                            
                
                                            
                                            <button class="btn btn-sm btn-success" id="addNewFile" title="Cargar Archivo" data-toggle="modal" data-target="#addNewFileModal{{$fila->id}}">
                                              <i class="fa fa-upload" aria-hidden="true"></i>
                                            </button>
                                              
                                            @include('modals.FileModals')
                                            
                                            @if (Auth::user()->accesoRuta('/consulta/registrar'))                        
                                              <a class="btn btn-info btn-sm btnIcono" title="Atender Consulta" href="{{route('consulta.iniciar', ['id'=> $fila->id] )}}" class=""><i id="iconoBoton" class="fa fa-stethoscope"></i></a>
                                              
                                            @endif 
                                            
                                            @if (Auth::user()->accesoRuta('/consulta/reasignar'))  
                                                  

                                                        <button type="button" title="Reasignar Consulta" class="btn btn-primary btn-sm btnIcono "                
                                                            data-toggle="modal" data-target="#reasignarConsultaDoctorModal{{$fila->id}}">
                                                            <i id="iconoBoton" class="fa fa-exchange"></i>
                                                        </button>
                                                        @include('modals.reasignarConsultaDoctorModals')
                                                  
                                                @endif 
                                              @if ($fila->tieneImprimir())
                                                <button class="btn  btn-warning btn-sm " id="addImprimir" title="Imprimir Documentos" data-toggle="modal" data-target="#imprimirModal{{$fila->id}}">
                                                  <i class="fa fa-print" aria-hidden="true"></i>
                                                </button>
                                                @include('modals.ImprimirModals3')
                                              @endif

                                            @if (Auth::user()->accesoRuta('/consulta/delete'))
                                                <a class="btn btn-danger btn-sm btnIcono" title="Eliminar consulta" href="{{route('consulta.delete', ['id'=> $fila->id] )}}" onclick="return confirm('Desea eliminar este consulta del sistema?')"><i class="fa fa-trash"></i></a> 
                                            @endif 
                                            
                                                                            
                                          </td>
                                        </tr>
                                      @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                      <tr>
                                        <th>ID</th>
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th>Sexo</th>
                                        <th>Edad</th>
                                        <th>Tiempo</th>                            
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Motivo</th>
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

    ,"order": [[0,'asc']]
     ,"columns": [
      null,
      null,
      { "width": "20%" },      
      null,
      null,
      null,
      null,
      { "width": "12%" },
      null,
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    @endsection








