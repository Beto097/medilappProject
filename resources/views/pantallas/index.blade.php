@extends('plantilla.plantillaDT')

@section('titulo')
    Pantallas
@endsection



@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todas las pantallas que se encuentran en el sistema</p>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary btn-lable-wrap left-label" id="addNewMedico" data-toggle="modal" data-target="#addNewPantallaModal">
                 <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                     Agregar Pantalla
                </span>
            </button>
            @include('modals.PantallaModals')
        </div>
        <br>
        <br>
        <br>
        @include('plantilla.errores')
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Pantallas</h6>
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
                                            <th>Nombre</th>
                                            <th>URL</th>       
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td scope="row">{{$fila->id}}</td>
                                                <td>{{$fila->nombre_pantalla}}</td> 
                                                <td>{{$fila->url_pantalla}}</td>
                                                <td>
                                                @if($permisos['update']==1)
                                                    <button type="button" class="btn btn-success btn-sm  btnIcono " id="editMedico"                
                                                    data-toggle="modal" data-target="#editarPantallaModal{{$fila->id}}">
                                                    <i id="iconoBoton" class="fa fa-edit"></i>
                                                    </button>
                                                    @include('modals.editarPantallaModals')
                                                    
                                                @endif
                                                @if($permisos['delete']==1)
                                                    <a class="btn btn-danger btn-sm" title="Eliminar pantalla" href="{{ route('pantalla.delete',['id' => $fila->id]) }}" onclick="
                                                    return confirm('Desea eliminar esta pantalla del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a>                                                   
                                        
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>URL</th>       
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
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection