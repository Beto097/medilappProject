@extends('plantilla.plantilla')

@section('titulo')
    Crear Paciente
@endsection

@section('css')
    <script>
       
        var app_url ='{{env('APP_URL')}}'; 
        function validar(){           
          const url = app_url+'/consultar/'+document.getElementById('txtCedula').value;
          fetch(url)
            .then(respuesta => respuesta.json() )
            .then(respuesta => {let cedula=respuesta.cedula ;
                if (cedula == document.getElementById('txtCedula').value ){
                    document.getElementById('AlertaCedula').innerHTML ='Este paciente ya existe';                    
                    document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-error"

                    
                    
                }
                else{
                    document.getElementById('AlertaCedula').innerHTML =""
                    document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-success"
                    
                    
                }
                if(document.getElementById("cedulaDiv").className == "form-group col-md-6 col-sm-12 col-xs-12 has-error"){
                    document.getElementById("btnCrear").disabled =true;
                }else{
                    document.getElementById("btnCrear").disabled =false;
                    
                }
            });
          
        }
        
    </script>
@endsection



@section('contenido')   
    <br>
    <br>

    <!--muestro el error-->
    @include('plantilla.errores')
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
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                    <label class="control-label mb-10 text-left">Cédula</label>
                                    <input type="text" class="form-control"  name="txtCedula" id="txtCedula" placeholder="Ejemplo:8-888-8888"  onfocusout="validar()"
                                        value="{{old ('txtcedula')}}" required>
                                    <small id="AlertaCedula" class="form-text text-muted"></small>
                                </div>
                                <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Sexo</label>
                                    <div class="radio radio-primary">
                                        <input type="radio" name="txtsexo" id="radioMasculino" value="m" checked="">
                                        <label for="radioMasculino">
                                            Masculino
                                        </label>
                                    </div>
                                    <div class="radio radio-info">
                                        <input type="radio" name="txtsexo" id="radioFemenino" value="f" >
                                        <label for="radioMasculino">
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
                                    <input type="date" class="form-control" id="inputfecnac" name="txtfecnac"
                                        value="{{old ('txtfecnac')}}" required>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Telefono</label>
                                    <input type="text" class="form-control form-control-sm" id="inputtelefono" placeholder="Ejemplo:66666666" name="txttelefono" 
                                        value="{{old ('txttelefono')}}"  >
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
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 " style="padding-top: 2rem">   
                                    <div class="modal-footer">
                                                                        
                                        <a href="{{route('paciente.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Agregar Paciente</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
    

@endsection

