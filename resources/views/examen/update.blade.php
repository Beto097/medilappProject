@extends('plantilla.plantilla')

@section('titulo')
   Actualizar Examen
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
                  <h6 class="panel-title txt-dark">Actualizar Examen</h6>
                  <span>Paso 1: Ingrese los datos que desea actualizar del examen</span>
              </div>
              <div class="clearfix"></div>
            </div>
            
            <div class="panel-body">
    
              <form action="{{route('examen.save')}}" method="POST" role="form" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                        <label class="control-label mb-10 text-left">Nombre del Examen:</label>
                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Tipaje" name="txtNombre"
                          value="{{$examen->nombre_examen}}" required>
                        
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <label for="exampleFormControlSelect1">Tipo de Examen:</label>
                      <select class="form-control" id="cbxTipoExamen" name="cbxTipoExamen">
                        @if ($examen->tipo_examen->estado_tipo_examen==0)
                          <option value='0'>Se puede dividir este examen</option>
                        @else
                          <option>Seleccione un tipo de Examen</option>
                          @foreach($tipo_examenes as $tipo_examen)
                            @if($examen->tipo_examen_id == $tipo_examen->id)
                              <option value="{{$tipo_examen->id}}" selected>{{$tipo_examen->nombre_tipo_examen}}</option>
                            @else
                              <option value="{{$tipo_examen->id}}">{{$tipo_examen->nombre_tipo_examen}}</option>
                            @endif
                          @endforeach
                        @endif
                        
                      </select>                               
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12" id="registroDiv">                                    
                      <label for="exampleFormControlSelect1">El Examen contiene valor de referencia:</label>
                      <select class="form-control" id="cbxReferencia" name="cbxReferencia">                               
                        
                        @if($examen->tiene_referencia == "0")
                          <option value="0" selected>No</option>
                          <option value="1">Si</option>
                        @else
                        <option value="0" >No</option>
                        <option value="1" selected>Si</option>
                        @endif
                        
                      </select>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <label for="">Descripcion del Examen:</label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Escriba una breve descripcion del examen">{{$detalle_examen}}</textarea>                             
                    </div>
                      
                </div>
                
                <div class="modal-footer">
                     <input type="hidden" name="txtid" value="{{$examen->id}}">                                   
                    <a href="{{route('examen.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                    <button type="submit" id="botoncrear" class="btn btn-primary text-left">Siguiente</button>
                </div>
            </form>
        
          </div>
            
        </div>
    </div>
</div>
      
@endsection









