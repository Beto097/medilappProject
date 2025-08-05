@extends('plantilla.plantilla')
@section('titulo')
    Crear medico
@endsection

@section('css')
    @include('scripts.validaciones')
@endsection



@section('contenido')
<br>
<br>

<!--muestro el error-->
    <div class="col-sm-4 col-sm-offset-8">
          @include('plantilla.errores')
        </div>
<!-- fin del error-->
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Crear Medico</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
                            <label class="control-label mb-10 text-left">Nombre del Doctor</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtNombre"
                                required>
                        </div>
                        <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
                            <label class="control-label mb-10 text-left">Numero de Registro</label>
                            <input type="text" class="form-control" id="inputPassword4" placeholder="Ejemplo:1538540" name="txtNumero" required>
                        </div>
                    
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label mb-10">Correo</label>
                            <div class="input-group mb-15"> <span class="input-group-addon">@</span>
                                <input type="email" placeholder="Ejemplo:juan@gmail.com" name="txtEmail" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label mb-10">Telefono</label>
                            <div class="input-group mb-15"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
                                name="txtTelefono">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                                                                
                        <a href="{{route('medico.index')}}"  class="btn btn-danger">Cancelar</a>
                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Medico</button>
                    </div>
                

                </form>
        </div>
    </div>
</div>

@endsection
