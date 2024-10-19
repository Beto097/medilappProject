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
    
    <div class="col-sm-10 col-sm-offset-1">
      <div class="panel panel-default card-view">
        <div class="panel-heading">
          <div class="pull-left">
              <h6 class="panel-title txt-dark">Crear nuevo Examen</h6>
              <span>Paso 2. Seleccione las caracteristicas que pertenecen a este Examen</span>
          </div>
          <div class="clearfix"></div>
        </div>
            
        <div class="panel-body">
          <form action="{{route('examen.insert2')}}" method="POST" role="form" autocomplete="off">
            @csrf
            <div class="row">
              @foreach($caracteristicas_examen as $caracteristica_examen)                  
                                 
                <div class="col-md-4">
                  <div class="checkbox checkbox-primary">
                    <input type="checkbox" class="form-check-input" name="caracteristicas_id[]" id="cbk{{$caracteristica_examen->id}}" value="{{$caracteristica_examen->id}}" @if(in_array($caracteristica_examen->id, $lista_caracteristicas))checked @endif>
                    <label for="cbk{{$caracteristica_examen->id}}">
                      {{$caracteristica_examen->nombre_caracteristica_examen}}
                    </label>
                  </div>                  
                </div>                
                  
              @endforeach
      
      
            </div>  
            <br>
            <br>
            <div class="modal-footer">
              <input type="hidden" name="txtid" id="inputtxtid" class="form-control" value="{{$id_examen}}">                                                   
              <a href="{{route('examen.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
              <a href="{{ route('examen.update',['id'=>$id_examen]) }}" class="btn btn-default " role="button" aria-pressed="true">Atras</a>
              <button type="submit" id="botoncrear" class="btn btn-primary text-left">Siguiente</button>
            </div>
      
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

