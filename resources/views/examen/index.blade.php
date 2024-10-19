@extends('plantilla.plantillaDT')

@section('titulo')
    Examenes
@endsection



@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los examenes creados en el sistema</p>
        </div>
        @if (Auth::user()->permisos('examen','create'))
            <div class="col-sm-2">
                <a class="btn btn-primary btn-lable-wrap left-label" href="{{route('examen.create')}}">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Crear nuevo Examen
                    </span>
                </a>
            
            </div>
        @endif
        
        <br>
        <br>
        <br>
        @include('plantilla.errores')
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
                                            <th>Nombre</th>                                            
                                            <th>Tipo de Examen</th>
                                            <th class="text-center">Caracteristicas</th>                                                          
                                            <th>Acciones</th>   
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td scope="row">{{ $fila->id }}</td>
                                                <td>{{ $fila->nombre_examen }}</td>
                                            
                                                <td>{{ $fila->tipo_examen->nombre_tipo_examen}}</td>
                                                <td class="text-center">
                                                    {{count($fila->examen_caracteristica_examen)}}
                                                </td>
                                                <td>
                                                    @if(Auth::user()->permisos('examen','update'))                                                        
                                                        
                                                        <a class="btn btn-success btn-sm" title="Modificar examen" href="{{ route('examen.update', ['id' => $fila->id]) }}" ><i id="iconoBoton" class="fa fa-edit"></i></a>
                                                        <a class="btn btn-info btn-sm" title="Ordenar examen" href="{{ route('examen.crear3', ['id' => $fila->id]) }}" ><i id="iconoBoton" class="fa fa-list"></i></a>
                                                        
                                                    @endif
                                                    @if(Auth::user()->permisos('examen','delete'))
                                                        
                                                        @if($fila->estado_examen == 1)
                                                            <a class="btn btn-danger btn-sm" title="Eliminar examen" href="{{ route('examen.delete', ['id' => $fila->id]) }}" onclick="
                                                                return confirm('Desea eliminar este examen del sistema?')"><i class="fa fa-trash-o"></i></a> 
                                                            </a>                                        
                                                            
                                                        @else
                                                            <a class="btn btn-warning btn-sm" title="Desbloquear examen" href="{{route('examen.desbloquear', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea desbloquear este examen del sistema?')"><i class="fa fa-unlock-alt"></i></a> 
                                                            </a> 
                                                        @endif
                                                                                                            
                                                    @endif 
                                                </td>  
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>Id</th>
                                            <th>Nombre</th>                                            
                                            <th>Tipo de Examen</th>
                                            <th class="text-center">Caracteristicas</th>                                                          
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
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection