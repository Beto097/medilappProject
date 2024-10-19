@extends('plantillas.plantilla')

@section('titulo')
    Crear Orden
@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    @include('scripts.validaciones')
@endsection

@section('logopantalla')
<i class="fas fa-file-medical"></i>
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
    <h1>Nueva Orden</h1>
</div>
    
    <div id="cardcrear" class="card col-lg-8">
        <div class="card-body">
            <form action="{{route('orden_laboratorio.insert')}}" method="POST" role="form" autocomplete="off">
                @csrf

                <div class="form-row ">
                    <div class="form-group col-md-12">
                        <label for="">Cedula del Paciente:</label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text"
                                        class="form-control is-valid" name="txtCedula" disabled id="txtCedula" aria-describedby="helpId" placeholder="Ingrese la identificacion del Paciente" 
                                        value="{{$paciente->identificacion_paciente}} " required
                                    >
                                    <small id="AlertaCedula" class="form-text text-muted">{{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}}</small>                            
                            
                                </div>
                                <div class="col-md-6 justify-content-around">
                                    <div class="form-group col-md-10">                 
                        
                        
                                        <button id="btnCrearPaciente" type="button" class="btn-block btn btn-primary btn-lg btnCrear"              
                                            data-toggle="modal" data-target="#addNewPacienteModal" disabled>
                                            Crear Nuevo Paciente
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            
                        
                        </div>
                        
                        
                    </div>
                    
                </div>
                
                

                <div class="form-row ">
                    <div class="form-group col-md-12">
                        <label for="">Registro del Medico:</label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text"
                                        class="form-control" name="txtRegistro" id="txtRegistro" aria-describedby="helpId" 
                                        onfocusout="validarRegistro()" placeholder="Ingrese el numero de registro del Medico" required
                                        value="@if(session('txtRegistro')){{session('txtRegistro')}}@endif">
                                    <small id="AlertaRegistro" class="form-text text-muted"></small>
                                    <small id="AlertaMedico" class="form-text text-muted"></small>
                        
                                </div>
                                <div class="col-md-6 justify-content-around">
                                    <div class="form-group col-md-10">  
                        
                                        <button id="btnCrearMedico" type="button" class="btn-block btn btn-primary btn-lg btnCrear"               
                                            data-toggle="modal" data-target="#addNewMedicoModal">
                                            Crear Nuevo Médico
                                        </button>
                            
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group col-6">
                   
                    <select class="form-control " hidden id="selectExterno" name="selectExterno" >
                        <option value='0' selected>Selecciones a quien Enviar</option>
                        @foreach ($externos as $externo)
                            <option value='{{$externo->id}}'>{{$externo->nombre_usuario}}</option>
                        @endforeach
                      </select>
                </div>
                
                <br>
                
                <div class="col-4"> 
                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="crearOrden" required>
                        <label class="custom-control-label" for="crearOrden">¿Desea crear esta orden?</label>
                    </div>
                </div>

                <div class="col-8">
                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="esExterno" name="esExterno" onclick="listaExterno();">
                        <label class="custom-control-label" for="esExterno">Pertenece a un Laboratorio Externo</label>
                    </div>
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
    @include('modals.MedicoModalsOrden')
@endsection
@section('footer')
    @include('plantillas.footer')
@section('contenidofooter')
@show
@endsection
