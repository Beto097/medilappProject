<div id="addNewMedicoModal"   class="modal fade" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-valmar">

                <h5 class="modal-title"><span class="font-weight-bold text-white">Agregar Médico</span></h5>

                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body text-left" >
                <form action="{{route('medico.insert')}}" method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nombre del Doctor</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan"  name="txtNombre"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Numero de Registro</label>
                            <input type="text" class="form-control" id="txtRegistro2" placeholder="Ejemplo:1538540" onfocusout="validarRegistro2()" name="txtNumero" required>
                            <small id="AlertaRegistro2" class="form-text text-muted"></small>
                            <small id="AlertaMedico2" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <label for="">Correo</label>
                    <div class="input-group flex-nowrap">
    
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                            aria-describedby="addon-wrapping" name="txtEmail">
                    </div>
                    <br>
                    <label for="">Telefono</label>
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-phone-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
                            name="txtTelefono" value="">
                    </div>
                    <br>
                    <br>  
                    <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="3">                 
                    @if(Request::url() === env('APP_URL').'/orden_laboratorio/create')
                    
                        <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">

                    
                    @endif
                    

                    
                    <input type="hidden" name="txtCedula" id="txtCedula3" class="form-control form-control-sm" 
                        value="@if(isset($paciente->identificacion_paciente)){{$paciente->identificacion_paciente}}@endif">
                    

                    <div class="row justify-content-around"> 
                        <div class="col-8">

                        </div>
                        <div class="col-4"> 
                            <button type="submit" id="btnCrearMedicoModal" class="btn btn-info btn-lg"> Agregar Médico</button>
                        </div>    
                        
                    
                    </div>
                    
    
                </form>

               

            </div>

        </div>

    </div>

</div>
