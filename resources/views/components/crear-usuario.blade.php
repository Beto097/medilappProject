<div class="row" style="padding-top: 15px"> 
    <div class="form-group col-md-6">
        <label for="txtNameUsuario">Nombre</label>
        <input type="text" class="form-control" id="txtNameUsuario" placeholder="Ejemplo:Juan" name="txtNameUsuario"
            value="{{ old('txtNameUsuario') }}" required>
    </div>
    <div class="form-group col-md-6">
        <label for="txtLastName">Apellido</label>
        <input type="text" class="form-control" id="txtLastName" placeholder="Ejemplo:Perez" 
            value="{{ old('txtLastName') }}" name="txtLastName" required>                            
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre de Usuario</label>
        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Jperez" name="txtUsuario"
            value="{{ old('txtUsuario') }}" required>
    </div>
    <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="txtPassword" placeholder="" 
            value="{{ old('txtPassword') }}" name="txtPassword" required>                            
    </div>
    <div class="form-group col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10">Correo</label>
        <div class="input-group mb-15"> <span class="input-group-addon">@</span>
            <input type="email" value="{{ old('txtEmail') }}" placeholder="Ejemplo:juan@gmail.com" name="txtEmail" class="form-control">
        </div>
    </div>
    <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10 text-left">Estado</label>
            
        <div class="radio radio-primary">
            <input type="radio" name="txtEstado" id="radio1" value="1" checked >
            <label for="radio1">
                Activado
            </label>
        </div>
        <div class="radio radio-info">
            <input type="radio" name="txtEstado" id="radio2" value="0"  @if(old('txtEstado')=='0') checked @endif>
            <label for="radio2">
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

                        <option value="{{$fila_rol->id}}" @if (old('selectRol')==$fila_rol->id)selected @endif>{{$fila_rol->nombre_rol}} </option>
                    
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
                    <option value='null' selected>Sin Sucursal</option>
                    @foreach($sucursales as $sucursal)                                                
                       
                        <option value="{{$sucursal->id}}" @if (old('selectSucursal')==$sucursal->id) selected @endif>{{$sucursal->nombre_sucursal}}</option>                                               
                    
                    @endforeach
                    
                    
                </select>
            </div>
        </div>
            
        
    </div>
</div>

<div class="modal-footer">                                        
    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Agregar Usuario</button>
</div>