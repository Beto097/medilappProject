@extends('plantilla.plantilla')
@section('titulo')
    Crear Caracteristica de Examen
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
                    <h6 class="panel-title txt-dark">Crear Caracteristica de Examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form" autocomplete="off">
                    @csrf
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Nombre caracteristica:</label>
                            <input type="text" class="form-control" id="" placeholder="" name="txtNombre" required> 
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Unidad:</label>
                            <input type="text" class="form-control" id="" placeholder="" name="txtUnidad" >
                        </div>

                        
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlTextarea1">Valor:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="txtValor" rows="5"></textarea>
                        </div>
                       
                        
                        <div class="form-check col-md-12">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1' checked>
                            <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                        </div>
                    </div>
                    
                    
                   
                    <div class="form-row">
                        <div class="form-group col-md-12 " style="padding-top: 2rem">   
                    
                            <div class="modal-footer">
                                                                        
                                <a href="{{route('caracteristica_examen.index')}}"  class="btn btn-danger">Cancelar</a>
                                <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Caracteristica</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
