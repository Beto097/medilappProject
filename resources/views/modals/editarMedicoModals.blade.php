<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarMedicoModal{{$fila->id}}"  aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Medico</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('medico.save')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Nombre del Doctor</label>
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Juan" name="txtNombre"
                                            value="{{$fila->nombre_medico}}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Numero de Registro</label>
                                        <input type="text" class="form-control" id="txtRegistro4" placeholder="Ejemplo:1538540" 
                                            value="{{$fila->numero_registro}}" name="txtNumero" required>                            
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10">Correo</label>
                                        <div class="input-group mb-15"> <span class="input-group-addon">@</span>
                                            <input type="email" value="{{$fila->email_medico}}" placeholder="Ejemplo:juan@gmail.com" name="txtEmail" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10">Telefono</label>
                                        <div class="input-group mb-15"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" value="{{$fila->telefono_medico}}" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
                                            name="txtTelefono">
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">

                                <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$fila->id}}">
                                
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
                                </div>
                                
                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
