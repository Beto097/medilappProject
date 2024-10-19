@extends('plantilla.plantilla')

@section('titulo')
    Crear Orden
@endsection
@section('bodyJs')
    onload="cargaPagina()"
@endsection

@section('css')    
    @include('scripts.validaciones')
@endsection



@section('contenido')
    <br>
    <br>

    <!--muestro el error-->
    @include('plantilla.errores')

    <div class="row">
        
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Crear Orden de Laboratorio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        <form action="" method="POST" role="form" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-7 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                    <label class="control-label mb-10 text-left">Cédula:</label>
                                    <input type="text" class="form-control"  name="txtCedula" id="txtCedula" placeholder="Ejemplo:8-888-8888"  onfocusout="validar()"
                                        value="@if(session('txtCedula')){{session('txtCedula')}}@endif" required>
                                    <small id="AlertaCedula" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-5 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 "><br></label>
                                    <button id="btnCrearPaciente" type="button" class="btn-block btn btn-primary btn-sm btnCrear"               
                                        data-toggle="modal" data-target="#addNewPacienteModal">
                                        Crear Nuevo Paciente
                                    </button>                                   
                                </div>
                                <div class="form-group col-md-7 col-sm-12 col-xs-12" id="registroDiv">                                    
                                    <label class="control-label mb-10 text-left">Registro del Medico:</label>
                                    <input type="text" class="form-control" name="txtRegistro" id="txtRegistro" aria-describedby="helpId" onfocusout="validarRegistro()" placeholder="Ingrese el numero de registro del Medico" 
                                            required value="@if(session('txtRegistro')){{session('txtRegistro')}}@endif">
                                    <small id="AlertaRegistro" class="form-text text-muted"></small><br>
                                    <small id="AlertaMedico" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group col-md-5 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 "><br></label>
                                    <button id="btnCrearMedico" type="button" class="btn-block btn btn-primary btn-sm btnCrear"               
                                        data-toggle="modal" data-target="#addNewMedicoModal">
                                        Crear Nuevo Médico
                                    </button>                                
                                </div>
                                <div class="form-group col-md-7 col-sm-12 col-xs-12" id="select" hidden>                   
                                    <select class="form-control" id="selectExterno" name="selectExterno" >
                                        <option value='0' selected>Selecciones a quien Enviar</option>
                                        @foreach ($externos as $externo)
                                            <option value='{{$externo->id}}'>{{$externo->nombre_usuario}}</option>
                                        @endforeach
                                      </select>
                                </div>    
                                <div class="form-group col-md-7 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input id="crearOrden" name="crearOrden" required type="checkbox">
                                        <label for="crearOrden">
                                            ¿Desea crear esta orden?
                                        </label>
                                    </div> 
                                    
                                </div>                                
                                <div class="form-group col-md-7 col-sm-12 col-xs-12" @if (Auth::user()->company->company_name!='Valmar') hidden @endif >
                                    <div class="checkbox">
                                        <input id="esExterno" name="crearOrden"  type="checkbox"  onclick="listaExterno();">
                                        <label for="esExterno">
                                            Pertenece a un Laboratorio Externo
                                        </label>
                                    </div> 
                                    
                                </div>                    
                            </div>
                            
                            <div class="modal-footer">
                                                                    
                                <a href="{{route('orden_laboratorio.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                                <button type="submit" id="botoncrear" class="btn btn-primary text-left">Siguiente</button>
                            </div>
                        </form>
                        
                        
                    </div>
                
            </div>
        </div>
    </div>
               
    @include('modals.PacienteModalsOrden')
    @include('modals.MedicoModalsOrden')

@endsection
