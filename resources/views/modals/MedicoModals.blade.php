<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewMedicoModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Medico</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('medico.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label for="inputEmail4">Nombre del Doctor</label>
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtNombre"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12" id="registroDiv">
                                        <label for="">Registro del Medico:</label>
                                        <input type="text"
                                            class="form-control" name="txtNumero" id="txtRegistro2" aria-describedby="helpId" 
                                            onfocusout="validarRegistro2()" placeholder="Ingrese el numero de registro del Medico" required
                                            value="">
                                        <small id="AlertaRegistro2" class="form-text text-muted"></small>
                                        <small id="AlertaMedico2" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10">Correo</label>
                                        <div class="input-group mb-15"> <span class="input-group-addon">@</span>
                                            <input type="email" placeholder="Ejemplo:juan@gmail.com" name="txtEmail" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10">Telefono</label>
                                        <div class="input-group mb-15"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
                                            name="txtTelefono">
                                        </div>
                                    </div>
                                
                                    
                                </div>                                
                               
                                @if(Request::url() === env('APP_URL').'/orden_laboratorio/create')
                                
                                    <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">

                                @else
                                    <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="1">
                                @endif
                                <input type="hidden" name="txtCedula2" id="txtCedula2" class="form-control form-control-sm" value="">
                                

                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Agregar Medico</button>
                                </div>
                                
                
                            </form>
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>
