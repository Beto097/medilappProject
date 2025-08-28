@extends('plantilla.plantillaDT')

@section('titulo')
    Actualizar Orden de Laboratorio
@endsection

@section('css')
    @include('scripts.validaciones')
    <style>
        .btn-mi-color {
            background-color: #499fad !important;
            color: #fff !important;
            border: none;
        }
        .btn-mi-color:hover, .btn-mi-color:focus {
            background-color: #357a8a !important;
            color: #fff !important;
        }
    </style>
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
                    document.getElementById('AlertaCedula').innerHTML ="Esta cédula no existe, debe crear el paciente"
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
                    document.getElementById('AlertaRegistro').innerHTML ="Este médico no existe, debe crearlo";
                    document.getElementById('AlertaMedico').innerHTML ='Puede ingresar "0" si no tiene médico';
                    document.getElementById("txtRegistro").className = "form-control is-invalid"; 
                    
                    
                }
            });
          
        }
    </script>
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
                        <h6 class="panel-title txt-dark">Actualizar Orden de Laboratorio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    <form action="{{ route('ordenlaboratorio.save') }}" method="POST" role="form" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label mb-10 text-left">Fecha de la Orden</label>
                                <input type="date" class="form-control" name="txtFecha" value="{{$fila->fecha_orden}}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label mb-10 text-left">Cédula del Paciente</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control is-valid" name="txtCedula" 
                                               value="{{$paciente->identificacion_paciente}}" id="txtCedula" 
                                               onfocusout="validar()" placeholder="Ingrese la identificación del Paciente" required>
                                        <small id="AlertaCedula" class="form-text text-muted">{{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-rounded btn-mi-color" 
                                                data-toggle="modal" data-target="#addNewPacienteModal">
                                            <i class="fa fa-plus"></i> Crear Nuevo Paciente
                                        </button>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label mb-10 text-left">Registro del Médico</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control is-valid" name="txtRegistro" 
                                               value="{{$medico->numero_registro}}" id="txtRegistro" 
                                               onfocusout="validarRegistro()" placeholder="Ingrese el número de registro del Médico" required>
                                        <small id="AlertaRegistro" class="form-text text-muted">{{$medico->nombre_medico}}</small>
                                        <small id="AlertaMedico" class="form-text text-muted"></small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-rounded btn-mi-color" 
                                                data-toggle="modal" data-target="#addNewMedicoModal">
                                            <i class="fa fa-plus"></i> Crear Nuevo Médico
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="txtId" value="{{ $fila->id }}">
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="customControlInline" required>
                                    <label for="customControlInline">¿Desea modificar esta orden?</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" id="botoncrear" class="btn btn-primary btn-rounded btn-mi-color btn-block">
                                    <i class="fa fa-check"></i> Siguiente
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('ordenlaboratorio.index')}}" class="btn btn-danger btn-rounded btn-block">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
    
    @include('modals.PacienteModalsOrden')
    @include('modals.MedicoModalsOrden')
@endsection
