@extends('plantilla.plantillaDT')

@section('titulo')
    Examenes
@endsection

@section('css')
    
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        @include('plantilla.errores')
        <div class="col-sm-10">
            <p>Este listado muestra los examenes que pertenecen a la orden de laboratorio.</p>
        </div>
        <div class="col-sm-2">
                   
        </div>
        <br> 
        <div class="col-lg-10 col-md-offset-1">
            <div class="col-md-12 text-center"><h4>Orden de Laboratorio Nº: {{$orden->id}}</h4></div>
            <div class="col-md-4"><h5>Fecha: {{$orden->fecha_orden}}</h5></div>
            <div class="col-md-4 text-center"><h5>Paciente: {{$orden->paciente->nombre_paciente}} {{$orden->paciente->apellido_paciente}}</h5></div>
            <div class="col-md-4 text-right"><h5>Identificacion: {{$orden->paciente->identificacion_paciente}}</h5></div>
            <div class="col-md-6"><h5>Medico: {{$orden->medico->nombre_medico}}-{{$orden->medico->numero_registro}}</h5></div>
            <div class="col-md-6 text-right"><h5>Estado: 
                @if($orden->estado_orden_laboratorio=='Pendiente')
                    <span class="label label-danger">{{$orden->estado_orden_laboratorio}}</span>  
                @elseif($orden->estado_orden_laboratorio=='En Proceso')
                    <span class="label label-warning">{{$orden->estado_orden_laboratorio}}</span> 
                @else
                    <span class="label label-success">{{$orden->estado_orden_laboratorio}}</span>   
                @endif                
                @if($orden->enviado == '1') <i class="fas fa-paper-plane"></i>@endif</h5></div>
        </div>          
        
        
        <div class="d-flex">
            <div class="mr-auto p-2">
                
            </div>
            @if (Auth::user()->permisos('ordenesLaboratorio','insert'))
                @if($orden->estado_orden_laboratorio == 'Terminado')                    
                    @if($count == 0)
                        @foreach ($tipos_examen as $tipo)
                            <div class="p-2"><a title="Imprimir todos los examenes de..." href="{{ route('imprimir.XGrupo', ['id'=>$orden->id,'tipo' => $tipo->id]) }}" class="btn btn-dark btn-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                                <span class="text">{{$tipo->nombre_tipo_examen}}</span>
                            </a></div>
                        @endforeach
                    @endif
                @endif
                                         
            @endif 
           
            
        </div>
    
       
        
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Examenes</h6>
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
                                            <th>Examen</th> 
                                            <th>Estado</th>                                                                                         
                                            <th>Acciones</th>    
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        @foreach ($resultado as $fila)
                                
                                            @if ($fila->padre<=0) 
                                                <tr>
                                                    <td scope="row ">{{ $fila->id}}</td>
                                                    <td>
                                                        @if (isset($fila->examen))
                                                            {{$fila->examen->nombre_examen}}
                                                        @else
                                                            Sin Examen
                                                        @endif
                                                        
                                                    </td>
                                                    <td> 
                                                        @if($fila->estado_examen=='Pendiente')
                                                            <span class="label label-warning">{{$fila->estado_examen}}</span>  
                                                        @else
                                                            <span class="label label-success">{{$fila->estado_examen}}</span>  
                                                        @endif
                                                    </td>
                                                    <td>
                                                        
                                                        @if($fila->estado_examen=='Pendiente')                                            
                                                            @if ($permisos['insert']==1)
                                                                @if ($fila->examen->es_externo==1)
                                                                    <div class="row  justify-content-center">
                                                                        <div class="col-6">
                                                                            <a class="btn btn-danger btn-sm btn-block" href="{{ route('ordenLaboratorio.examen.terminado', ['id' => $fila->id]) }}" role="button">Terminado</a>
                                                                        </div>                                                                
                                                                    </div>
                                                                @else  
                                                                    @if (isset($fila->examen))
                                                                        @if ($fila->padre==-1)
                                                                            <a class="btn btn-primary btn-sm" href="{{ route('ordenLaboratorio.resultados1', ['id' => $fila->id]) }}" role="button">Registrar Resultados</a>
                                                                        @else
                                                                            <a class="btn btn-primary btn-sm" href="{{ route('ordenLaboratorio.resultados', ['id' => $fila->id]) }}" role="button">Registrar Resultados</a>
                                                                        @endif
                                                                    @else
                                                                        <a class="btn btn-danger btn-sm" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button">Eliminar Fila</a>
                                                                    @endif
                                                                @endif
                                                            
                                                                
                                                                
                                                            @endif
                                                        
                                                        @else
                                                            
                                                            @if (Auth::user()->permisos('orden_laboratorio','ver'))
                                                                @if ($fila->examen->es_externo==1)
                                                                    <div class="row  justify-content-center">
                                                                        <div class="col-6">
                                                                            <a class="btn btn-info btn-sm btn-block disabled" href="#" role="button" disabled>Terminado</a>
                                                                        </div>                                                                
                                                                    </div>
                                                                @else    
                                                                    @if (isset($fila->examen))                                                                                                                        
                                                                    
                                                                        <a class="btn btn-success btn-sm" title="Ver resultados" href="{{ route('ordenLaboratorio.ver.resultados', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="fa fa-eye"></i></a>
                                                                        <a class="btn btn-default btn-sm" title="Imprimir resultado" href="{{ route('imprimir.resultado', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="fa fa-print"></i></a>
                                                                        
                                                                        @if ($fila->orden_laboratorio->enviado == '0' && Auth::user()->rol_id != 2)
                                                                            <a class="btn btn-primary" title="Enviar al correo" href="{{ route('enviar.correo', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="fa fa-paper-plane"></i></a>
                                                                        @endif 
                                                                    
                                                                    @else
                                                                        <a class="btn btn-danger btn-sm" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button">Eliminar Fila</a>
                                                                    @endif
                                                                @endif
                                                                    
                                                            @endif
                                                            
                                                            @if(Auth::user()->permisos('ordenesLaboratorio','update'))
                                                                @if ($fila->examen->es_externo!=1)
                                                                    @if (isset($fila->examen))
                                                                        <a class="btn btn-info btn-sm" title="Modificar resultados" href="{{ route('ordenLaboratorio.update.resultados', ['id' => $fila->id]) }}" ><i id="iconoBoton" class="fa fa-edit"></i></a>
                                                                                                                                    
                                                                    @endif
                                                                @endif  
                                                                    
                                                            @endif
                                                            
                                                        @endif  

                                                        
                                                                                        
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>Id</th>
                                            <th>Examen</th> 
                                            <th>Estado</th>                                                                                         
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

    
     ,"columns": [      
      null,
      null,
      null,
      { "width": "18%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection

