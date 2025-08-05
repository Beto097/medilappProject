<div class="form-row">
    <div class="form-group col-md-6">
        <label for="txtNameUsuario">Nombre</label>
        <input type="text" class="form-control" id="txtNameUsuario" placeholder="Ejemplo:Juan" name="txtNameUsuario"
            value="{{ $fila->primer_nombre_usuario }}" required>
    </div>
    <div class="form-group col-md-6">
        <label for="txtLastName">Apellido</label>
        <input type="text" class="form-control" id="txtLastName" placeholder="Ejemplo:Perez" 
            value="{{ $fila->apellido_usuario }}" name="txtLastName" required>                            
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre de Usuario</label>
        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Jperez" name="txtUsuario"
            value="{{$fila->nombre_usuario}}" required>
    </div>
    <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="txtPassword" placeholder="Ejemplo:1538540" 
            value="{{$fila->password_usuario}}" name="txtPassword" required>                            
    </div>
    <div class="form-group col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10">Correo</label>
        <div class="input-group mb-15"> <span class="input-group-addon">@</span>
            <input type="email" value="{{$fila->email_usuario}}" placeholder="Ejemplo:juan@gmail.com" name="txtEmail" class="form-control">
        </div>
    </div>
    <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10 text-left">Estado</label>
            
        <div class="radio radio-primary">
            <input type="radio" name="txtEstado" id="radio1-{{$fila->id}}" value="1" @if($fila->estado_usuario=="1") checked @endif >
            <label for="radio1-{{$fila->id}}">
                Activado
            </label>
        </div>
        <div class="radio radio-info">
            <input type="radio" name="txtEstado" id="radio2-{{$fila->id}}" value="0" @if($fila->estado_usuario=="0") checked @endif  >
            <label for="radio2-{{$fila->id}}">
                Bloqueado
            </label>
        </div>	
    </div>  
    <div class="form-group col-md-6 col-sm-6 col-xs-12">                                        
        <div class="input-group mb-3">
            <label for="">Seleccione un Rol</label>                                                                           
            <div class="col-sm-12">
                <select class="form-control" name="selectRol" id="">
                    @foreach($roles as $fila_rol)                                                
                       
                            
                            @if($fila_rol->id == $fila->rol->id)
                                <option value="{{$fila_rol->id}}" selected>{{$fila_rol->nombre_rol}} </option>
                            @else  
                                <option value="{{$fila_rol->id}}">{{$fila_rol->nombre_rol}}</option>
                            @endif
                       
                    
                    @endforeach
                    
                    
                </select>
            </div>
        </div>
            
        
    </div>
    <div class="form-group col-md-6 col-sm-6 col-xs-12">                                        
        <div class="input-group mb-3">
            <label for="">Seleccione una Sucursal</label>                                                                           
            <div class="col-sm-12">
                <select class="form-control" name="selectSucursal" id="">
                    <option value='null' selected>Sin Sucursal prueba</option>
                    @foreach($sucursales as $sucursal)                                                
                        @if(isset($fila->sucursal))
                            @if($sucursal->id == $fila->sucursal->id)
                                <option value="{{$sucursal->id}}" selected>{{$sucursal->nombre_sucursal}} </option>
                            @else
                                <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}} </option>
                            @endif
                        @else  
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}}</option>
                           

                        @endif
                            
                           
                    
                    @endforeach
                    
                    
                </select>
            </div>
        </div>
            
        
    </div>
</div>                               


<input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$fila->id}}">

<div class="modal-footer">                                        
    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
</div>