@extends('plantilla.plantilla')

@section('titulo')
    Crear Paciente
@endsection

@section('css')
    @include('scripts.validaciones')
    @include('scripts.menorEdad')
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
                        <h6 class="panel-title txt-dark">Crear Paciente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        
                        <form action="{{route('paciente.insert')}}" method="POST" role="form" autocomplete="off">
                            @csrf
                            
                                
                                <div class="form-group col-md-6 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                    <label class="control-label mb-10 text-left">Cédula</label>
                                    <input type="text" class="form-control"  name="txtCedula" id="txtCedula2" placeholder="Ejemplo:8-888-8888"  onfocusout="validar2()"
                                        value="{{old ('txtcedula')}}" required>
                                    <small id="AlertaCedula2" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Sexo</label>
                                    <div class="radio radio-primary">
                                        <input type="radio" name="txtsexo" id="radio1" value="m" checked="">
                                        <label for="radio1">
                                            Masculino
                                        </label>
                                    </div>
                                    <div class="radio radio-info">
                                        <input type="radio" name="txtsexo" id="radio2" value="f" >
                                        <label for="radio2">
                                            Femenino
                                        </label>
                                    </div>	
                                </div>                                    
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                    <label class="control-label mb-10 text-left">Nombre</label>
                                    <input type="text" class="form-control" id="inputnombre" placeholder="Ejemplo:Juan" name="txtnombre"
                                        value="{{old ('txtnombre')}}" required >
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                    <label class="control-label mb-10 text-left">Apellido</label>
                                    <input type="text" class="form-control form-control-sm" id="inputapellido" placeholder="Ejemplo:Perez" name="txtapellido"
                                        value="{{old ('txtapellido')}}" required > 
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="txtfecnac" name="txtfecnac"  onchange="validarEdad()"
                                        value="{{old ('txtfecnac')}}" required>
                                </div>
                                <div id="contenidoMayor" class="hidden">

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">  
                                        <label class="control-label mb-10 text-left">Estado Civil</label>
                                        <select class="form-control" name="txtEstadoCivil" id="">                                            
                                            
                                            <option value="Soltero/a">Soltero/a</option>
                                            <option value="Casado/a">Casado/a</option>
                                            <option value="Unido/a">Unido/a</option>                   
                                        
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left">Lugar de Trabajo</label>
                                        <input type="text" class="form-control form-control-sm" id="inputtrabajo" placeholder="Ejemplo: Contruccion" name="txtTrabajo" 
                                            value="{{old ('txtTrabajo')}}" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Telefono</label>
                                    <input type="text" class="form-control form-control-sm" id="inputtelefono" placeholder="Ejemplo:66666666" name="txttelefono" 
                                        value="{{old ('txttelefono')}}"  >
                                </div>
                                
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Direccion</label>
                                    <input type="text" class="form-control form-control-sm" id="inputdireccion" placeholder="Ejemplo: Carrasquilla" name="txtDireccion" 
                                        value="{{old ('txtDireccion')}}" >
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left" for="example-email">Correo</label>
                                    <div class="input-group mb-15"> <span class="input-group-addon">@</span>
                                        <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" 
                                            name="txtemail" value="{{old ('txtemail')}}">
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Comentarios</label>
                                    <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" name="txtComentario" rows="2">{{old ('txtComentario')}}</textarea>
                                </div>
                                    
                                
                                
                            
                            <div class="modal-footer">
                                                                    
                                <a href="{{route('paciente.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                                <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Paciente</button>
                            </div>
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
    

@endsection

