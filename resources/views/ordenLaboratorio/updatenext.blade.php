@extends('plantillas.plantilla')

@section('titulo')
    Actualizar Lista de Examen
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

@section('opcionmenu')
    <li class="nav-item">
        <a id="medicoa" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opcionesmedico"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-user"></i>
            <span>Orden - Actualizar</span>
        </a>
        <div id="opcionesmedico" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones Orden:</h6>
                <a class="collapse-item" href="{{ route('orden_laboratorio.index') }}">Lista de Ordenes</a>
                <!-- <a class="collapse-item" href="{{ route('usuario.create') }}">Insertar Usuario</a> -->
                <!-- <a class="collapse-item" href="forgot-password.html">Forgot Password</a> -->
            </div>
        </div>
    </li>
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
    
    <div id="cardcrear" class="card col-lg-11">
        <div class="card-body">
            <form action="{{ route('orden_laboratorio.updatenext') }}" method="POST" role="form" autocomplete="off">
                @csrf

                @foreach($tipo_examen as $tipo)
                    <div class="col-md-12 bg-secondary text-white">
                
                        <h3>{{$tipo->nombre_tipo_examen}}</h3>
                    </div>
                    @foreach($examenes as $examen)

                        @if($examen->tipo_examen_id == $tipo->id)
                                @if(in_array($examen->id,$lista_examenes))
                                    <div class="form-check-inline col-3">
                                        <label class="form-check-label"><h4>
                                            <input type="checkbox" class="form-check-input" value="{{$examen->id}}" name="examenes_id[]" checked >{{$examen->nombre_examen}}
                                            </h4>
                                        </label>
                                    </div>
                                @else
                                <div class="form-check-inline col-3">
                                    <label class="form-check-label"><h4>
                                        <input type="checkbox" class="form-check-input" value="{{$examen->id}}" name="examenes_id[]">{{$examen->nombre_examen}}
                                        </h4>
                                    </label>
                                </div>
                                @endif
                                


                        @else
                        @endif

                    @endforeach
 
                @endforeach

                <input type="hidden" name="txtOrdenLaboratorio" id="input" class="form-control" value="{{ $id_orden_laboratorio }}">
           
                <div class="row justify-content-around"> 
                    <div class="col-3"> 
                    <a href="{{route('orden_laboratorio.update',['id'=>$id_orden_laboratorio])}}" class="btn btn-secondary btn-lg" id="botoncrear">Atras</a>
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
    @include('plantillas.footer')
@section('contenidofooter')
@show
@endsection
