@extends('plantilla.plantilla')

@section('titulo')
    Crear Orden de Laboratorio
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
                        <h6 class="panel-title txt-dark">Crear Nueva Orden de Laboratorio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    <form action="{{ route('ordenlaboratorio.insert') }}" method="POST" role="form" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label mb-10 text-left">Cédula del Paciente</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="txtCedula" id="txtCedula" 
                                               onfocusout="validar()" placeholder="Ingrese la identificación del Paciente" 
                                               required value="@if(session('txtCedula')){{session('txtCedula')}}@endif">
                                        <small id="AlertaCedula" class="form-text text-muted"></small>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="btnCrearPaciente" type="button" class="btn btn-primary btn-rounded btn-mi-color"               
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
                                        <input type="text" class="form-control" name="txtRegistro" id="txtRegistro" 
                                               onfocusout="validarRegistro()" placeholder="Ingrese el número de registro del Médico" 
                                               required value="@if(session('txtRegistro')){{session('txtRegistro')}}@endif">
                                        <small id="AlertaRegistro" class="form-text text-muted"></small>
                                        <small id="AlertaMedico" class="form-text text-muted"></small>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="btnCrearMedico" type="button" class="btn btn-primary btn-rounded btn-mi-color"               
                                                data-toggle="modal" data-target="#addNewMedicoModal">
                                            <i class="fa fa-plus"></i> Crear Nuevo Médico
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6" style="display: none;" id="externoDiv">
                                <label class="control-label mb-10 text-left">Laboratorio Externo</label>
                                <select class="form-control" id="selectExterno" name="selectExterno">
                                    <option value='0' selected>Seleccione a quien enviar</option>
                                    @foreach ($externos as $externo)
                                        <option value='{{$externo->id}}'>{{$externo->nombre_usuario}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="crearOrden" required>
                                    <label for="crearOrden">¿Desea crear esta orden?</label>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="esExterno" name="esExterno" onclick="listaExterno();">
                                    <label for="esExterno">Pertenece a un Laboratorio Externo</label>
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
    
    <script>
        function listaExterno() {
            var checkbox = document.getElementById('esExterno');
            var selectDiv = document.getElementById('externoDiv');
            
            if (checkbox.checked) {
                selectDiv.style.display = 'block';
            } else {
                selectDiv.style.display = 'none';
            }
        }
    </script>
@endsection
