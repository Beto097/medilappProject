@extends('plantilla.plantilla')
@section('titulo')
    Crear Sucursal
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
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Crear Sucursal</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route('sucursal.insert')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
                <x-crear-sucursal />
                
            </form>
        </div>
    </div>
</div>

@endsection
