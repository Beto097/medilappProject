<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewUsuarioModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Usuario</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('usuario.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Usuario</label>
                                        <input type="text" class="form-control" id="txtUsuarioM" placeholder="Ejemplo:Juan" name="txtUsuario"
                                            onfocusout="userName()"
                                            value= "" required>
                                            <span id="AlertaUsuario"></span>
                                        
                                    </div>
                                    @if (Auth::user()->rol_id=1)
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label for="">Seleccione una compañia</label>
                                                <select class="form-control" name="txtCompany" id="" value="" required>
                                                
                                                    @foreach($companys as $company)
                                                
                                                    
                                                        <option value="{{$company->id}}" >{{$company->company_name}}</option>
                                                    
                                                    
                                                    @endforeach
                                            
                                                </select>
                                            </div>
                                            @error('txtCompany')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Contraseña</label>
                                        <input type="password" class="form-control" id="inputPassword4" placeholder="" name="txtContraseña"
                                        value= ""  required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="inputEmail4" placeholder="" name="txtContraseña_confirmation"
                                        value= ""  required>
                                    </div>
                
                                </div>
                              
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        
                                        <div class="form-group">
                                          <label for="">Seleccione un Rol</label>
                                          <select class="form-control" name="txtRol" id="" value="" required>
                                            
                                            @foreach($roles as $rol)
                                        
                                            
                                                <option value="{{$rol->id}}" >{{$rol->nombre_rol}}</option>
                                           
                                            
                                            @endforeach
                                        
                                          </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                       
                                        <div class="form-group">
                                          <label for="">Seleccione un Estado </label>
                                          <select class="form-control" name="txtEstado" id="" required value="">
                
                                            
                                            <option value = "0">Bloqueado</option>
                                            <option value = "1" selected >Activo</option>
                                           
                                            
                                          </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Correo</label>
                                        
                        
                                            
                                        <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                                            aria-describedby="addon-wrapping"
                                            name="txtEmail" value= "" required>
                        
                        
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Agregar Usuario</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

