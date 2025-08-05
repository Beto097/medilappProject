@extends('plantilla.plantilla')
@section('titulo')
    Crear Pantalla
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
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Crear Pantallas</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route('pantalla.insert')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
                <x-crear-pantalla />
                
            </form>
        </div>
    </div>
</div>

@endsection
