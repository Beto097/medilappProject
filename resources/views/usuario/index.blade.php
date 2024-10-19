@extends('plantilla.plantillaDT')

@section('titulo')
    Usuarios
@endsection

@section('css')    
    @include('scripts.validaciones')
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los usuarios que se encuentran en el sistema.</p>
        </div>
        @if (Auth::user()->permisos('usuario','create'))
            <div class="col-sm-2">
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewPaciente" data-toggle="modal" data-target="#addNewUsuarioModal"> <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">Agregar Usuario</span></button>
                @include('modals.UsuarioModals')
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
                        <h6 class="panel-title txt-dark">Usuarios</h6>
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
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            @if (Auth::user()->rol_id==1)
                                                <th>Compañia</th>
                                            @endif
                                            <th>Email</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td scope="row">{{$fila->id}}</td>
                                                <td>{{$fila->nombre_usuario}}</td>                            
                                                <td>{{$fila->rol->nombre_rol}}</td>
                                                @if($fila->estado_usuario == 1)
                                                    <td>Activo</td>
                                                @else 
                                                    <td>Bloqueado</td>
                                                @endif
                                                @if (Auth::user()->rol_id==1)
                                                    @if ($fila->company)
                                                        <th>{{$fila->company->company_name}}</th>
                                                    @else
                                                        <th></th>
                                                    @endif
                                                    
                                                @endif
                                                <td>{{$fila->email_usuario}}</td>
                                                
                                                <td>
            
                                                    @if (Auth::user()->permisos('usuario','update'))
                                                        <button type="button" class="btn btn-success btn-sm" id="editMedico"                
                                                            data-toggle="modal" data-target="#editarUsuarioModal{{$fila->id}}">
                                                            <i id="iconoBoton" class="fa fa-edit"></i>
                                                        </button>
                                                        @include('modals.editarUsuarioModals')
                                                    @endif
                                                    @if (Auth::user()->permisos('usuario','delete'))
                                                        @if($fila->estado_usuario == 1)                                        
                                                            <a class="btn btn-danger btn-sm" title="Eliminar usuario" href="{{ route('usuario.bloquear', ['id' => $fila->id]) }}" onclick="
                                                                return confirm('Desea eliminar este usuario del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a> 
                                                        @else
                                                            <a class="btn btn-warning btn-sm" title="Desbloquear usuario" href="{{ route('usuario.desbloquear', ['id' => $fila->id]) }}" onclick="
                                                                return confirm('Desea desbloquear este usuario del sistema?')"><i id="iconoBotonW" class="fa fa-unlock-alt"></i></a> 
                                                            <a class="btn btn-danger btn-sm" title="Eliminar usuario definitivamente" href="{{ route('usuario.delete', ['id' => $fila->id]) }}" onclick="
                                                                return confirm('Desea eliminar este usuario del sistema?')"><i id="iconoBoton" class="fa fa-trash-o"></i></a> 
                                                            
                                                        @endif
                                                            
                                                            
                                                    @endif                                            
                                                    
                
                
                                                
                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>                                                                                   
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            @if (Auth::user()->rol_id==1)
                                                <th>Compañia</th>
                                            @endif
                                            <th>Email</th>
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
      @if (Auth::user()->rol_id==1)
        null,
      @endif      
      null,
      null,
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection