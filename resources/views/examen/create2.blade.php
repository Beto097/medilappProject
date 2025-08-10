@extends('plantilla.plantilla')
@section('titulo')
    @if (Route::is('examen.create'))
        Crear Examen

    @else
        Actualizar Examen
    @endif
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
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="text-center">  
                    <h4>  
                        @if (Route::is('examen.create'))
                            Crear Nuevo Examen
                    
                        @else
                            Actualizar Examen
                        @endif
                    </h4>
                    <h6>Paso 2: Seleccione las Caracteristicas del examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route ('examen.insert2')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
                <div class="row">  
                    @foreach($caracteristicas_examen as $caracteristica_examen)
                        
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="caracteristicas_id[]" id="" value="{{$caracteristica_examen->id}}" @if(in_array($caracteristica_examen->id, $lista_caracteristicas)) checked  @endif   >
                                <span>{{$caracteristica_examen->nombre_caracteristica_examen}}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                    
                    
                  </div>  

                <div class="modal-footer">       
                    <input type="hidden" name="txtid" id="inputtxtid" class="form-control" value="{{$id_examen}}">                                 
                    <div class="row justify-content-around" >
                        
                        <div class="col-4">   
                            <a href="{{ route('examen.index') }}" class="btn btn-danger btn-lg" role="button" aria-pressed="true">Cancelar</a>  
                            <a href="{{ route('examen.update',['id'=>$id_examen]) }}" class="btn btn-warning btn-lg" role="button" aria-pressed="true">Atras</a>         
                            <button type="submit" class="btn btn-primary btn-lg">Siguiente</button>
                        </div>
                    </div>
                </div>
                
                
            </form>
        </div>
    </div>
</div>

@endsection
