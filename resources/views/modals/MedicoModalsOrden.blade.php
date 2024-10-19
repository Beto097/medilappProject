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
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12" > 
                                        <label class="control-label mb-10 text-left">Nombre del Doctor</label>
                                        <input type="text" class="form-control"  placeholder="Ejemplo:Juan Rodriguez"  name="txtNombre"
                                            required> 
                                    </div>
                                    <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12" id="registroDiv3">
                                        <label class="control-label mb-10 text-left">Numero de Registro</label>
                                        <input type="text" class="form-control" id="txtRegistroModalOrden" placeholder="Ejemplo:1538540" onfocusout="validarRegistro3()" name="txtNumero" required>
                                        <small id="AlertaRegistro3" class="form-text text-muted"></small>
                                        <small id="AlertaMedico3" class="form-text text-muted"></small>
                                    </div>                                    
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                        <label class="control-label mb-10 text-left">Correo</label>
                                        <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" aria-label="Username"
                                            aria-describedby="addon-wrapping" name="txtEmail">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                        <label class="control-label mb-10 text-left">Telefono</label>
                                        <input type="text" class="form-control" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
                                        name="txtTelefono" value="">
                                    </div>
                                   
                                    @if(Request::url() === env('APP_URL').'/orden_laboratorio/create')
                    
                                        <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">
                
                                    @else
                                        <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="1">
                                    @endif
                                    <input type="hidden" name="txtCedula" id="txtCedula3" class="form-control form-control-sm" 
                                        value="@if(isset($paciente->identificacion_paciente)){{$paciente->identificacion_paciente}}@endif">
                                
                                
                                    <div class="modal-footer">                                        
                                        <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Agregar Medico</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

