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
              <h6 class="panel-title txt-dark">Ordenar Examen</h6>
              <span>Paso 3: Ordene las caracteristicas seleccionadas</span>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel-body">


          <div class="lista" id=lista>
            @foreach ($caracteristicas as  $key =>  $caracteristica)

              <div class="caracteristica row justify-content-around" data-id={{$caracteristica->caracteristica_examen_id}}>
                <button class="btn btn-rounded btn-outline btn-primary  col-sm-4 col-sm-offset-4">{{$caracteristica->caracteristica_examen->nombre_caracteristica_examen}}</button>
              </div>             
              
            
            
            @endforeach
          </div>
          
            
          
          <br>
          <br>
          <form action="{{route ('examen.insert3')}}" method="POST" role="form" autocomplete="off">
            @csrf
             
            <br>
            <br>
            <div class="modal-footer">
              <input type="hidden" name="inputOrden" id="inputOrden" class="form-control" value="">
              <input type="hidden" name="examen_id" id="inputOrden" class="form-control" value={{$examen_id}}>                                                
              <a href="{{route('examen.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
              <a href="{{ route('examen.update2',['id'=>$examen_id]) }}" class="btn btn-default " role="button" aria-pressed="true">Atras</a>
              <button type="submit" id="botoncrear" class="btn btn-primary text-left">Guardar</button>
            </div>
      
          </form>
        </div>
      </div>
    </div>
  </div>

    
@endsection

@section('javaScript')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script src="{{asset('vendors/bower_components/bootstrap/dist/js/main.js')}}"></script>

@endsection

