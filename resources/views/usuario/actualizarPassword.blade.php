@extends('plantilla.plantilla')
@section('titulo')
    Cambiar Contraseña
@endsection




@section('contenido')
<br>
<br>

<!--muestro el error-->
@include('plantilla.errores')
<!-- fin del error-->
<div class="row">
    
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Cambie su Contraseña</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-10 col-md-offset-1">
                            <label for="inputPassword4">Contraseña Actual</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="" name="txtPasswordActual"
                            value= "{{old ('txtPasswordActual') }}"  required>
                            @error('txtPasswordActual')
                                <small id="helpId" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        
                        
                    
                    
                        
                        <div class="form-group col-md-10 col-md-offset-1">
                            <label for="inputPassword4">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="" name="txtPasswordNuevo"
                            value= "{{old ('txtPasswordNuevo') }}"  required>
                            @error('txtPasswordaNueva')
                                <small id="helpId" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        
                 
                        <div class="form-group col-md-10 col-md-offset-1">
                            <label for="inputEmail4">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="inputEmail4" placeholder="" name="txtPasswordConfirmacion"
                            value= "{{old ('txtPasswordConfirmacion') }}"  required>
                            @error('txtPasswordConfirmacion')
                                <small id="helpId" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        
    
                    </div>
                    
                    
                    
                    
                    <br>
                    <br>
                    <input type="hidden" name="txtId" id="input" class="form-control" value="{{ $usuario->id }}">
                    <div class="modal-footer">
                                                                
                        <a href="{{route('index')}}"  class="btn btn-danger">Cancelar</a>
                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Guardar</button>
                    </div>
                

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
