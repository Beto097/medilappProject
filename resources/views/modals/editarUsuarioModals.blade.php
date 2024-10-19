<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarUsuarioModal{{$fila->id}}"  aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Usuario</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{ route('usuario.save') }}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Usuario</label>
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtUsuario"
                                            required value="{{$fila->nombre_usuario}}">
                                          
                                    </div>
                                    
                                
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Contraseña</label>
                                        <input type="password" class="form-control" id="inputPassword4" placeholder="Ejemplo:Perez" name="txtContraseña"
                                        required value="{{$fila->password_usuario}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="">Seleccione un Rol</label>
                                            <select class="form-control" name="txtRol" id="" value="{{$fila->rol_id}}" required>
                                            
                                                @foreach($roles as $rol)
                                                    
                                                    <option value="{{$rol->id}}" 
                                                        @if($rol->id == $fila->rol_id) 
                                                            selected
                                                        @endif >

                                                        {{$rol->nombre_rol}}
                                                
                                                    </option>

                                                @endforeach

                                                
                                        
                                            </select>
                                        </div>
                                  
                                    </div>
            
                                    <div class="form-group col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="">Seleccione un Estado </label>
                                            <select class="form-control" name="txtEstado" id="" required value="{{$fila->estado_usuario}}">
            
                                                @if($fila->estado_usuario == 0)
                                                    <option value = "0" selected>Bloqueado</option>
                                                    <option value = "1">Activo</option>
                                                @else
                                                    <option value = "0" >Bloqueado</option>
                                                    <option value = "1" selected>Activo</option>
                                                @endif
                                                
                                            </select>
                                        </div>
                                    
                                    </div>
            
            
                                    <div class="form-group col-md-12">
                                
                                        <label for="">Correo</label>
                                        
                    
                                            
                                        <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                                            aria-describedby="addon-wrapping" name="txtEmail"  value="{{$fila->email_usuario}}" required>
                                       
                                    </div>
                                                
                
                                    <input type="hidden" name="txtId" id="input" class="form-control" value="{{ $fila->id }}">
                                </div>
                                <br>
                                <br>
                                
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
                                </div>
                                
                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
