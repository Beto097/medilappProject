<div id="addNewPacienteModal"   class="modal fade" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-valmar">

                <h5 class="modal-title"><span class="font-weight-bold text-white">Agregar Paciente</span></h5>

                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body text-left" >

                <form action="{{route('paciente.insert')}}" method="POST" role="form" autocomplete="off">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputcedula">Cédula</label>
                            <input type="text" class="form-control form-control-sm "  name="txtCedula" id="txtCedula2" placeholder="Ejemplo:8-888-8888"  onfocusout="validar2()"
                                value="{{old ('txtcedula')}}" required>
                                <small id="AlertaCedula2" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputsexo">Sexo</label>
                          <div class="form-check col-md-6">
                              <input type="radio" class="form-check-input" name="txtsexo" id="radio1" value="m" <?php if(old('txtsexo')=="m"){echo 'checked="checked"';}?> checked>
                              <label class="form-check-label" for="radio1">Masculino</label>
                          </div>
                          <div class="form-check col-md-6">
                              <input type="radio" class="form-check-input" name="txtsexo" id="radio2" value="f" <?php if(old('txtsexo')=="f"){echo 'checked="checked"';}?>>
                              <label class="form-check-label" for="radio2">Femenino</label>
                            </div>
                        </div> 
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputnombre">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="inputnombre" placeholder="Ejemplo:Juan" name="txtnombre"
                            value="{{old ('txtnombre')}}" required >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputapellido">Apellido</label>
                            <input type="text" class="form-control form-control-sm" id="inputapellido" placeholder="Ejemplo:Perez" name="txtapellido"
                            value="{{old ('txtapellido')}}" required > 
                        </div>
    
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            
                            <label for="inputfecnac">Fecha de Nacimiento</label>
                           
                            <input type="date" class="form-control form-control-sm" id="inputfecnac" name="txtfecnac"
                            value="{{old ('txtfecnac')}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputtelefono">Telefono</label>
                            <input type="text" class="form-control form-control-sm" id="inputtelefono" placeholder="Ejemplo:66666666" name="txttelefono" date-format="dd-mm-yyyy"
                            value="{{old ('txttelefono')}}">
                        </div>
                    </div>
                   
                    <label for="">Correo</label>
                    <div class="input-group flex-nowrap">
    
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="email" class="form-control form-control-sm" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                            aria-describedby="addon-wrapping" name="txtemail" value="{{old ('txtemail')}}">
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlTextarea1">Comentario</label>
                            <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" name="txtComentario" rows="2">{{old ('txtComentario')}}</textarea>
                        </div>
                    </div>
                    @if(Request::url() === env('APP_URL').'/orden_laboratorio/create')
                    
                        <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">

                    @else
                        <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="1">
                    @endif
                    <input type="hidden" name="txtRegistro" id="txtRegistro3" class="form-control form-control-sm" value="">
                   
                    <div class="row justify-content-around"> 
                        <div class="col-8">

                        </div>
                        <div class="col-4"> 
                            <button type="submit" id="btnCrearModal" class="btn btn-info btn-lg"> Agregar Paciente</button>
                        </div>    
                        
                    
                    </div>
                    <br>
                    
                  </form>

            </div>

        </div>

    </div>

</div>
