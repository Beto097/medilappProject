@extends('plantilla.plantillaDT')

@section('titulo')
   Roles
@endsection



@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los roles que se encuentran en el sistema</p>
        </div>
        @if (Auth::user()->permisos('rol','create'))
            <div class="col-sm-2">
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewMedico" data-toggle="modal" data-target="#addNewRolModal">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Agregar Rol
                    </span>
                </button>
                @include('modals.RolModals')
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
                        <h6 class="panel-title txt-dark">Roles</h6>
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
                                            <th>Nombre rol</th>
                                            @if (Auth::user()->rol_id==1)
                                                <th>Compañia</th>
                                            @endif        
                                            <th> Acciones </th>
                                          </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $key => $fila)
                                            <tr>
                                                <td scope="row">{{$key+1}}</td>
                                                
                                                <td>{{$fila->nombre_rol}}</td>
                                                @if (Auth::user()->rol_id==1)
                                                    @if ($fila->company)
                                                        <th>{{$fila->company->company_name}}</th>
                                                    @else
                                                        <th></th>
                                                    @endif
                                                    
                                                @endif                          
                                                <td>

                                                    @if (Auth::user()->permisos('rol','update'))
                                                        <button type="button" class="btn btn-success btn-sm" id="editMedico"                
                                                            data-toggle="modal" data-target="#editarRolModal{{$fila->id}}">
                                                            <i id="iconoBoton" class="fa fa-edit"></i>
                                                        </button>
                                                        {{-- @include('modals.editarRolModals') --}}
                                                    @endif
                                                    @if (Auth::user()->permisos('rol','delete'))
                                                        @if($fila->estado_rol == 1)                                        
                                                            <a class="btn btn-danger btn-sm" title="Eliminar Rol" href="{{route('rol.delete', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea eliminar este rol del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a> 
                                                        @else
                                                            <a class="btn btn-warning btn-sm" href="{{route('rol.desbloquear', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea desbloquear este rol del sistema?')"><i id="iconoBotonW" class="fa fa-trash-o"></i></a> 
                                                        @endif
                                                        
                                                    @endif                                            
                                                
                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre rol</th> 
                                                @if (Auth::user()->rol_id==1)
                                                    <th>Compañia</th>
                                                @endif      
                                                <th> Acciones </th>
                                            </tr>
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