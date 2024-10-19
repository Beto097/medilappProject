@extends('plantilla.plantilla')

@section('titulo')
    Crear Examen
@endsection



@section('contenido')
<br>
<br>

<!--muestro el error-->
@include('plantilla.errores')

<div class="row">
    
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Crear nuevo Examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
                <div class="panel-body">
                    <form action="" method="POST" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                <label class="control-label mb-10 text-left">Nombre del Examen:</label>
                                <input type="text" class="form-control" id="" placeholder="Ejemplo: Tipaje" name="txtNombre"
                                    value="@if(session('txtNombre')){{session('txtNombre')}}@endif" required>
                                
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                              <label for="exampleFormControlSelect1">Tipo de Examen:</label>
                              <select class="form-control" id="cbxTipoExamen" name="cbxTipoExamen">
                                <option value='0'>Se puede dividir este examen</option>
                                @foreach($tipo_examenes as $tipo_examen)
                                  <option value="{{$tipo_examen->id}}">{{$tipo_examen->nombre_tipo_examen}}</option>
                                @endforeach
                                
                              </select>                               
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12" id="registroDiv">                                    
                              <label for="exampleFormControlSelect1">El Examen contiene valor de referencia:</label>
                              <select class="form-control" id="cbxReferencia" name="cbxReferencia">                               
                                
                                <option value="0">No</option>
                                <option value="1">Si</option>
                                
                              </select>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                              <label for="">Descripcion del Examen:</label>
                              <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Escriba una breve descripcion del examen"></textarea>                             
                            </div>
                              
                        </div>
                        
                        <div class="modal-footer">
                                                                
                            <a href="{{route('examen.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                            <button type="submit" id="botoncrear" class="btn btn-primary text-left">Siguiente</button>
                        </div>
                    </form>
                    
                    
                </div>
            
        </div>
    </div>
</div>

  
    
        
       
        
      
@endsection


