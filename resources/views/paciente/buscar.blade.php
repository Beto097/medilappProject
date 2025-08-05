@extends('plantilla.plantilla')
@section('titulo')
    Buscar Paciente
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
                    <h6 class="panel-title txt-dark">Buscar Paciente</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route('paciente.search')}}" method="POST" role="form" autocomplete="off">
                @csrf
                <div class="form-row" style="padding-top: 15px">
                    

                        <div class="form-group col-md-6">
                            <label for=""></label>
                            <input type="text" class="form-control" value="" id="" placeholder="Ingrese un Texto" name="txtBuscar" required>
                            
                        </div>
                        
                
                        
                    
                    
                    <div class="modal-footer">                                        
                        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Buscar</button>
                    </div>
                </div>
                
                
            </form>
        </div>
    </div>
</div>

@endsection