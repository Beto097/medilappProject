@extends('plantilla.plantilla')

@section('titulo')
    Elegir Examen
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
                        <h6 class="panel-title txt-dark">Listado de examenes</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        <form action="{{ route('orden_laboratorio.next') }}" method="POST" role="form" autocomplete="off">
                            @csrf
                            <div class="row">
                                @foreach($tipo_examen as $tipo)
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <h4>{{$tipo->nombre_tipo_examen}}</h4>                                    
                                    </div>
                                    
                                    @foreach($caracteristica_examen as $caracteristicas_examen)

                                        @if($caracteristicas_examen->tipo_examen_id == $tipo->id)
                                            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                                <div class="checkbox">
                                                    <input id="{{$caracteristicas_examen->id}}" name="examenes_id[]" value="{{$caracteristicas_examen->id}}" type="checkbox">
                                                    <label for="{{$caracteristicas_examen->id}}">
                                                        {{$caracteristicas_examen->nombre_examen}}
                                                    </label>
                                                </div> 
                                                
                                            </div>
                                            
                                        @endif

                                    @endforeach
                    
                                @endforeach
                            </div>                            
                               
                            <input type="hidden" name="txtNueva_Orden" id="input" class="form-control" value="{{ $nueva_orden }}">
           
                            <br>
                            <br>                            
                            <div class="modal-footer">
                                                                    
                                <a href="{{route('orden_laboratorio.update',['id'=>$nueva_orden])}}"  class="btn btn-danger text-rigth">Atras</a>
                                <button type="submit" id="botoncrear" class="btn btn-primary text-left">Siguiente</button>
                            </div>
                        </form>
                        
                        
                    </div>
                
            </div>
        </div>
    </div>
               
 
@endsection


