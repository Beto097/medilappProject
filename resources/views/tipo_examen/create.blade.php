@extends('plantilla.plantilla')
@section('titulo')
    Crear Tipo de Examen
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
                    <h6 class="panel-title txt-dark">Crear Tipo de Examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Tipo Examen</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Parasitología" name="txttipoexamen" required>
                        </div>                    
                    </div>
                    <br>
                    <br>                
                    
                    <div class="modal-footer">
                                                                
                        <a href="{{route('tipoexamen.index')}}"  class="btn btn-danger">Cancelar</a>
                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Tipo de Examen</button>
                    </div>
                

                </form>
        </div>
    </div>
</div>

@endsection
