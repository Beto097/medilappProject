@extends('plantilla.plantillaDT')

@section('titulo')
    Caracteristicas de Examenes
@endsection



@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra una serie de caracteristicas de examenes del sistema</p>
        </div>
        <div class="col-sm-2">

            @if (Auth::user()->permisos('caracteristicaExamen','create'))

                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewMedico" data-toggle="modal" data-target="#addNewCaracteristicaModal">
                        <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Crear Caracteristica
                    </span>
                </button>
                @include('modals.CaracteristicaModals')
                
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
                        <h6 class="panel-title txt-dark">Caracteristicas de Examenes</h6>
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
                                            <th>Unidad</th>
                                            <th>Valor</th>                               
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                        <tr>
                                            <td scope="row">{{ $fila->id }}</td>
                                            <td>{{$fila->nombre_caracteristica_examen}}</td>
                                            <td>{{$fila->unidad_caracteristica_examen}}</td>
                                            <td>{!!$fila->valor_referencia_caracteristica_examen!!}</td>
                                            <td>
                                                @if (Auth::user()->permisos('caracteristicaExamen','update'))                                                                      
                                                    <button type="button" class="btn btn-success btn-sm"              
                                                        data-toggle="modal" data-target="#editarCaracteristicaModal{{$fila->id}}">
                                                        <i id="iconoBoton" class="fa fa-edit"></i>
                                                    </button>
                                                    @include('modals.editarCaracteristicaModals')
                                                @endif
                                                @if (Auth::user()->permisos('caracteristicaExamen','delete'))  
                                                
                                                    @if($fila->estado_caracteristica_examen == 1)
                                                
                                                        <a class="btn btn-danger btn-sm" title="Eliminar caracteristica" href="{{route('caracteristica_examen.eliminar',['id' => $fila->id] )}}" onclick="
                                                            return confirm('Desea eliminar este examen del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a>
                                                    @else
        
                                                        <a class="btn btn-warning btn-sm" title="Desbloquear caracteristica" href="{{route('caracteristica_examen.desbloquear',['id' => $fila->id] )}}" onclick="
                                                            return confirm('Desea desbloquear este examen del sistema?')"><i id="iconoBotonW" class="fa fa-unlock-alt"></i></a>
        
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
                                            <th>Unidad</th>
                                            <th>Valor</th>                               
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