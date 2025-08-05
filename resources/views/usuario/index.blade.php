@extends('plantilla.plantillaDT')

@section('titulo')
    Usuario
@endsection

@section('css')    
    @include('scripts.validaciones')
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los usuario en el sistema</p>
        </div>
        <div class="col-sm-2">
            @if (Auth::user()->accesoRuta('/usuario/create'))  
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewusuario" data-toggle="modal" data-target="#addNewUsuarioModal">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Agregar Usuario
                    </span>
                </button>
                @include('modals.UsuarioModals')
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
                                            <th>Id</th>                                            
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Sucursal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr style="font-size: 90%;">
                                                <td scope="row">{{$fila->id }}</td>
                                                <td>{{ $fila->primer_nombre_usuario }}</td>
                                                <td>{{ $fila->apellido_usuario }}</td>
                                                <td>{{ $fila->nombre_usuario }}</td>
                                                <td>{{ $fila->email_usuario }}</td>
                                                <td>{{ $fila->rol->nombre_rol}}</td>
                                                <td>
                                                    @isset($fila->sucursal)
                                                        {{$fila->sucursal->nombre_sucursal}}
                                                    @endisset
                                                </td>
                                                <td>
                                                    @if (Auth::user()->accesoRuta('/usuario/update'))  
                                                        <button type="button" class="btn btn-success btn-sm" id="editUsuario"                
                                                            data-toggle="modal" data-target="#editarUsuarioModal{{$fila->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @include('modals.editarUsuarioModals')
                                                    @endif
                                                    @if (Auth::user()->accesoRuta('/usuario/delete'))  
                                                        
                                                        @if($fila->estado_usuario == 1)                                        
                                                            <a class="btn btn-danger btn-sm"title="Eliminar el usuario" href="{{route('usuario.delete', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea eliminar este usuario del sistema?')"><i class="fa fa-trash-o"></i></a> 
                                                        @else
                                                            <a class="btn btn-warning btn-sm" title="Desbloquear el usuario" href="{{route('usuario.desbloquear', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea desbloquear este usuario del sistema?')"><i class="fa fa-unlock-alt"></i></a> 
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
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Sucursal</th>
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
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection