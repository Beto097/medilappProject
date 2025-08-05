@extends('plantilla.plantilla')

@section('titulo')
    Ver Password Paciente
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
                    <h6 class="panel-title txt-dark">Ver Datos de Ingreso del Paciente</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
                <div class="panel-body">
                   
                    <div class="text-center col-12">
                        <h1>Hola {{$paciente->nombre_paciente}}!</h1>
                    </div>
                    <div class="text-center col-12">
                        <p>Hemos creado para ti una cuenta en nuestro sistema {{env('APP_URL')}}</p>
                    </div>
                    <br>
                    <br>              
                    <div class="text-center">
                        <div class="row">
                            <div class="col-6">
                                <h2>Usuario:</h2>
                            </div>
                            <div class="col-6">
                                <h2>{{$paciente->identificacion_paciente}}</h2>
                            </div>
                            <div class="col-6">
                                <h2>Contraseña:</h2>
                            </div>
                            <div class="col-6">
                                <h2>{{$password}}</h2>
                            </div>
                        </div>
                        
                    </div>
                </div>
            
        </div>
    </div>
</div>


   

    


@endsection
