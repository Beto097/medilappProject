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
    <div class="col-lg">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="text-center">
                        <h2 class="display-1 txt-dark font-weight-bold">Listado de exámenes</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <form action="{{ route('ordenlaboratorio.next') }}" method="POST" role="form" autocomplete="off">
                    @csrf

                    @foreach($tipo_examen as $tipo)
                        @if($tipo->estado_tipo_examen < 2)
                            <div class="col-md-12 bg-secondary text-white mb-3">
                                <h3 class="p-2">{{$tipo->nombre_tipo_examen}}</h3>
                            </div>
                            
                            @php $hayExamenes = false; @endphp
                            @foreach($caracteristica_examen as $caracteristicas_examen)
                                @if($caracteristicas_examen->tipo_examen_id == $tipo->id)
                                    @php $hayExamenes = true; @endphp
                                    <div class="form-check-inline col-md-3 mb-2">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="{{$caracteristicas_examen->id}}" name="examenes_id[]">
                                            <strong>{{$caracteristicas_examen->nombre_examen}}</strong>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if(!$hayExamenes)
                                <div class="col-md-12 mb-3">
                                    <p class="text-muted">No hay exámenes disponibles para este tipo.</p>
                                </div>
                            @endif
                        @endif
                    @endforeach

                    <input type="hidden" name="txtNueva_Orden" id="input" class="form-control" value="{{ $nueva_orden }}">
               
                    <br>
                    <br>
                    <br>
                   
                    <!-- Botón Atrás alineado a la izquierda -->
                    <div class="row mb-4"> 
                        <div class="col-3"> 
                            <a href="{{route('ordenlaboratorio.update',['id'=>$nueva_orden])}}" class="btn btn-secondary btn-lg">Atrás</a>
                        </div>
                    </div>
                    
                    <!-- Botón Guardar centrado completamente -->
                    <div class="container-fluid">
                        <div class="row justify-content-center mt-4"> 
                            <div class="col-auto text-center"> 
                                <button type="submit" id="botoncrear" class="btn btn-primary btn-lg">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </div>                   
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @if(isset($tipo_examen) && $tipo_examen->count() > 0)

        <!--<div id="cardcrear" class="card col-lg-10">
            <div class="card-body">
                <form action="{{ route('ordenlaboratorio.next') }}" method="POST" role="form" autocomplete="off">
                    @csrf

                    @foreach($tipo_examen as $tipo)
                        @if($tipo->estado_tipo_examen < 2)
                            <div class="col-md-12 bg-secondary text-white mb-3">
                                <h3 class="p-2">{{$tipo->nombre_tipo_examen}}</h3>
                            </div>
                            
                            @php $hayExamenes = false; @endphp
                            @foreach($caracteristica_examen as $caracteristicas_examen)
                                @if($caracteristicas_examen->tipo_examen_id == $tipo->id)
                                    @php $hayExamenes = true; @endphp
                                    <div class="form-check-inline col-md-3 mb-2">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="{{$caracteristicas_examen->id}}" name="examenes_id[]">
                                            <strong>{{$caracteristicas_examen->nombre_examen}}</strong>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if(!$hayExamenes)
                                <div class="col-md-12 mb-3">
                                    <p class="text-muted">No hay exámenes disponibles para este tipo.</p>
                                </div>
                            @endif
                        @endif
                    @endforeach

                    <input type="hidden" name="txtNueva_Orden" id="input" class="form-control" value="{{ $nueva_orden }}">
               
                    <br>
                    <br>
                    <div class="row justify-content-around"> 
                        <div class="col-3"> 
                            <a href="{{route('ordenlaboratorio.update',['id'=>$nueva_orden])}}" class="btn btn-secondary btn-lg">Atrás</a>
                        </div>
                        <div class="col-3"> 
                            <button type="submit" id="botoncrear" class="btn btn-primary btn-lg">
                                <i class="fas fa-check"></i> Guardar
                            </button>
                        </div>                   
                    </div>
                </form>
            </div>
        </div>-->
    @else
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">No hay exámenes disponibles</h4>
            <p>No se encontraron tipos de examen o exámenes activos en el sistema.</p>
            <hr>
            <p class="mb-0">Contacte al administrador para configurar los exámenes disponibles.</p>
        </div>
        
        <div class="row justify-content-center mt-4"> 
            <div class="col-3"> 
                <a href="{{route('ordenlaboratorio.index')}}" class="btn btn-secondary btn-lg">Volver a Órdenes</a>
            </div>
        </div>
    @endif

@endsection
@section('footer')
    @include('plantilla.footer')
@section('contenidofooter')
@show
@endsection
