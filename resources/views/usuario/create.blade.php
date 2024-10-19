@extends('plantilla.plantilla')
@section('titulo')
    Crear Usuario
@endsection




@section('contenido')
<br>
<br>

<!--muestro el error-->
@include('plantilla.errores')
<!-- fin del error-->
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Crear Usuario</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Usuario</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtUsuario"
                                value= "{{old ('txtUsuario') }}" required>
                                @error('txtUsuario')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
                            value= "{{old ('txtContraseña') }}"  required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="inputEmail4" placeholder="" name="txtContraseña_confirmation"
                            value= "{{old ('txtContraseña_confirmation') }}"  required>
                        </div>
                        @error('txtContraseña')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group col-md-6">                          
                            <div class="form-group">
                              <label for="">Seleccione un Rol</label>
                              <select class="form-control" name="txtRol" id="" value="" required>
                                
                                @foreach($roles as $rol)
                            
                                
                                <option value="{{$rol->id}}" >{{$rol->nombre_rol}}</option>
                               
                                
                                @endforeach
                            
                              </select>
                            </div>
                            @error('txtRol')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <!-- <label for="inputPassword4">Estado</label>
                            <input type="text" class="form-control" id="inputPassword4" placeholder="Ejemplo: 0" name="txtEstado"
                            value= "{{old ('txtEstado') }}" required> -->
                            <div class="form-group">
                              <label for="">Seleccione un Estado </label>
                              <select class="form-control" name="txtEstado" id="" required value="">
    
                                
                                <option value = "0">Bloqueado</option>
                                <option value = "1" selected >Activo</option>
                               
                                
                              </select>
                            </div>
                            @error('txtEstado')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Correo</label>                            
                            <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                                aria-describedby="addon-wrapping" name="txtEmail" value= "{{old ('txtEmail') }}" required>
        
            
                            
                            @error('txtEmail')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            
                        </div>
                    </div>                   
                    <br>
                    <div class="modal-footer">
                                                                
                        <a href="{{route('usuario.index')}}"  class="btn btn-danger">Cancelar</a>
                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Usuario</button>
                    </div>
                

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
