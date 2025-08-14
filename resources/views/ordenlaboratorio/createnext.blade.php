@extends('plantilla.plantillaDT')

@section('titulo')
    Elegir Examen
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
@endsection

@section('logopantalla')
    <i class="fas fa-user"></i>
@endsection

@section('titulopantalla')
    Orden Laboratorio
@endsection


@section('contenido')
    <!-- <div id="titulocrearusuario">
        <h1>Crear Usuario</h1>
    </div> -->

    <!--muestro el error-->
    @error('status')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $message }}</strong>
    </div>
    <script>
        $(".alert").alert();

    </script>
    @enderror
    <!-- fin del error-->
    <div class="text-center">
    <h1>Listado de examenes</h1>
</div>
    
    <div id="cardcrear" class="card col-lg-10">
        <div class="card-body">
            <form action="{{ route('ordenlaboratorio.next') }}" method="POST" role="form" autocomplete="off">
                @csrf

                @foreach($tipo_examen as $tipo)
                    @if($tipo->estado_tipo_examen <2)
                        <div class="col-md-12 bg-secondary text-white">
                    
                            <h3>{{$tipo->nombre_tipo_examen}}</h3>
                        </div>
                        @foreach($caracteristica_examen as $caracteristicas_examen)

                            @if($caracteristicas_examen->tipo_examen_id == $tipo->id)

                                <div class="form-check-inline col-md-3">
                                    <label class="form-check-label"><h5>
                                        <input type="checkbox" class="form-check-input" value="{{$caracteristicas_examen->id}}" name="examenes_id[]">{{$caracteristicas_examen->nombre_examen}}
                                        </h5>
                                    </label>
                                </div>
                            @endif

                        @endforeach
                        
                    @endif
 
                @endforeach

                <input type="hidden" name="txtNueva_Orden" id="input" class="form-control" value="{{ $nueva_orden }}">
           
                <br>
            	<br>
                <div class="row justify-content-around"> 
                    <div class="col-3"> 
                    <a href="{{route('ordenlaboratorio.update',['id'=>$nueva_orden])}}" class="btn btn-secondary btn-lg" id="botoncrear">Atras</a>
                    </div>
                    <div class="col-3"> 
                        <button type="submit" id="botoncrear" class="btn btn-primary btn-lg"><i class="fas fa-check"></i> Guardar</button>
                    </div>                   
                
                </div>
                    

            </form>
        </div>
    </div>

@endsection
@section('footer')
    @include('plantilla.footer')
@section('contenidofooter')
@show
@endsection
