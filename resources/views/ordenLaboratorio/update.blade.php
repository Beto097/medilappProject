@extends('plantillas.plantilla')

@section('titulo')
    Actualizar Orden
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script>
        var app_url ='{{env('APP_URL')}}'; 
        function validar(){            
          const url = app_url+'/consultar/'+document.getElementById('txtCedula').value;
          fetch(url)
            .then(respuesta => respuesta.json() )
            .then(respuesta => {let cedula=respuesta.cedula ;
                if (cedula == document.getElementById('txtCedula').value ){
                    document.getElementById('AlertaCedula').innerHTML =respuesta.nombre;                    
                    document.getElementById("txtCedula").className = "form-control is-valid";
                    
                }
                else{
                    document.getElementById('AlertaCedula').innerHTML ="esta cedula no existe debe crear el paciente"
                    document.getElementById("txtCedula").className = "form-control is-invalid";
                    
                    
                }
            });
          
        }
        function validarRegistro(){
          const url = app_url+'/consultarRegistro/'+document.getElementById('txtRegistro').value;
          fetch(url)
            .then(respuesta => respuesta.json() )
            .then(respuesta => {let registro=respuesta.registro ;
                if (registro == document.getElementById('txtRegistro').value ){
                    document.getElementById('AlertaRegistro').innerHTML =respuesta.nombre;                    
                    document.getElementById("txtRegistro").className = "form-control is-valid";
                    document.getElementById('AlertaMedico').innerHTML ="";
                }
                else{
                    document.getElementById('AlertaRegistro').innerHTML ="este medico no existe debe crearlo";
                    document.getElementById('AlertaMedico').innerHTML ='puede ingresar el "0" sino tiene medico';
                    document.getElementById("txtRegistro").className = "form-control is-invalid"; 
                    
                    
                }
            });
          
        }
    </script>
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
    <h1>Actualizar Orden</h1>
</div>
    
    <div id="cardcrear" class="card col-lg-8">
        <div class="card-body">
        
            <form action="{{ route('orden_laboratorio.save') }}" method="POST" role="form" autocomplete="off">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Fecha</label>
                        <input type="date" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtFecha"
                            value= "{{$fila->fecha_orden}}" required>
                            @error('txtUsuario')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    
                    
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="">Cedula del Paciente:</label>
                            <input type="text"
                            class="form-control is-valid" name="txtCedula" value="{{$paciente->identificacion_paciente}}" id="txtCedula" aria-describedby="helpId" onfocusout="validar()" placeholder="Ingrese la identificacion del Paciente" required>
                            
                            <small id="AlertaCedula" class="form-text text-muted">{{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}}</small>
                        
                        </div>
                        
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Nuevo Paciente</label>
                        <button type="button" class="btn btn-primary btn-sm btn-block">Crear</button>
                        
                    </div>
                          



                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="">Registro del Medico:</label>
                            <input type="text"
                            class="form-control is-valid" name="txtRegistro" value="{{$medico->numero_registro}}" id="txtRegistro" aria-describedby="helpId" onfocusout="validarRegistro()" placeholder="Ingrese el numero de registro del Medico" required>
                            <small id="AlertaRegistro" class="form-text text-muted">{{$medico->nombre_medico}}</small>
                            <small id="AlertaMedico" class="form-text text-muted"></small>
                        
                        </div>
                        
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nuevo Médico</label>
                        <button type="button" class="btn btn-primary btn-sm btn-block">Crear</button>
                        
                    </div>
                </div>

                
                <br>


                <input type="hidden" name="txtId" id="input" class="form-control" value="{{ $fila->id }}">
                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="customControlInline" required>
                    <label class="custom-control-label" for="customControlInline">¿Desea Modificar esta orden?</label>
                </div>
                <br>
            	<br>
                <div class="row justify-content-around"> 
                    <div class="col-4"> 
                        <button type="submit" id="botoncrear" class="btn btn-primary btn-lg"><i class="fas fa-check"></i> Siguiente</button>
                    </div>

                    <div class="col-4">
                        <a href="{{route('orden_laboratorio.index')}}" class="btn btn-danger  btn-lg" id="botoncrear"><i class="fas fa-times"></i> Cancelar</a>
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
