@extends('plantilla.plantilla')
@section('titulo')
    Crear Examen
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
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="text-center">  
                    <h4>Crear Nuevo Examen</h4>
                    <h6>Paso 3: Ordene las caracteristicas seleccionadas</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="lista" id=lista>
                @foreach ($caracteristicas as $caracteristica)
        
                <div class="caracteristica" data-id={{$caracteristica->caracteristica_examen_id}}>
                    <button class="btn btn-primary  col-12">{{$caracteristica->caracteristica_examen->nombre_caracteristica_examen}}</button>
                </div>
                
                
                
                
                @endforeach
            </div>
            <form action="{{route ('examen.insert3')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
               

                <div class="modal-footer">       
                    <div class="row justify-content-around" >
                        <input type="hidden" name="inputOrden" id="inputOrden" class="form-control" value="">
                        <input type="hidden" name="examen_id" id="inputOrden" class="form-control" value={{$examen_id}}>
                        <div class="col-4">   
                            <a href="{{ route('examen.index') }}" class="btn btn-danger btn-lg" role="button" aria-pressed="true">Cancelar</a>  
                            <a href="{{ route('examen.update2',['id'=>$examen_id]) }}" class="btn btn-warning btn-lg" role="button" aria-pressed="true">Atras</a>         
                            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                        </div>
                    </div>
                </div>
                
                
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{asset('js/main.js')}}"></script>
@endsection
