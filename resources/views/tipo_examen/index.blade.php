@extends('plantilla.plantillaDT')

@section('titulo')
    Tipo de Examenes
@endsection



@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los Tipo Examen que se encuentran en el sistema</p>
        </div>
        <div class="col-sm-2">
            @if (Auth::user()->permisos('tipoexamen','create'))
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewMedico" data-toggle="modal" data-target="#addNewTipoExamenModal">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Agregar Tipo Examen
                    </span>
                </button>
                @include('modals.TipoExamenModals')
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
                        <h6 class="panel-title txt-dark">Tipos De Examen</h6>
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
                                            <th>Tipo Examen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td scope="row">{{$fila->id}}</td>
                                                <td>{{$fila->nombre_tipo_examen}}</td>                          
                                                <td>
                                                    @if(Auth::user()->permisos('tipoexamen','update')) 
                                                        <button type="button" class="btn btn-success btn-sm" id="editMedico"                
                                                            data-toggle="modal" data-target="#editarTipoExamenModal{{$fila->id}}">
                                                            <i id="iconoBoton" class="fa fa-edit"></i>
                                                        </button>
                                                        @include('modals.editarTipoExamenModals')
                                                    @endif
                                                    @if(Auth::user()->permisos('tipoexamen','delete'))
                                                        
                                                        @if($fila->estado_tipo_examen == 1)                                        
                                                            <a class="btn btn-danger btn-sm" title="Eliminar tipo de examen" href="{{route('tipoexamen.delete', ['id' =>$fila->id])}}" onclick="
                                                                return confirm('Desea eliminar este tipo de examen del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a> 
                                                        @else
                                                            <a class="btn btn-warning btn-sm" title="Desbloquear tipo de examen" href="{{route('tipoexamen.desbloquear', ['id' =>$fila->id])}}" onclick="
                                                                return confirm('Desea desbloquear este tipo de examen del sistema?')"><i id="iconoBotonW" class="fa fa-unlock-alt"></i></a> 
                                                        @endif
                                                    @endif                                            
                                                
                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>ID</th>
                                            <th>Tipo Examen</th>
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
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection