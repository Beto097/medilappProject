<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarPacienteModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar Paciente</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('paciente.save')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <input type="hidden" id="txtCedulaOld" value="{{$fila->identificacion_paciente}}">
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                        <label class="control-label mb-10 text-left">Cédula</label>
                                        <input type="text" class="form-control"  name="txtCedula" id="txtCedula2" placeholder="Ejemplo:8-888-8888"  onfocusout="validar2()"
                                            value="{{$fila->identificacion_paciente}}" required>
                                        <small id="AlertaCedula2" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group mb-30 col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left">Sexo</label>
                                        	
                                        <div class="radio radio-primary">
                                            <input type="radio" name="txtsexo" id="radio1-{{$fila->id}}" value="m" @if($fila->sexo_paciente=="m") checked @endif >
                                            <label for="radio1-{{$fila->id}}">
                                                Masculino
                                            </label>
                                        </div>
                                        <div class="radio radio-info">
                                            <input type="radio" name="txtsexo" id="radio2-{{$fila->id}}" value="f" @if($fila->sexo_paciente=="f") checked @endif  >
                                            <label for="radio2-{{$fila->id}}">
                                                Femenino
                                            </label>
                                        </div>	
                                    </div>                                    
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                        <label class="control-label mb-10 text-left">Nombre</label>
                                        <input type="text" class="form-control" id="inputnombre" placeholder="Ejemplo:Juan" name="txtnombre"
                                            value="{{$fila->nombre_paciente}}" required >
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">                                    
                                        <label class="control-label mb-10 text-left">Apellido</label>
                                        <input type="text" class="form-control form-control-sm" id="inputapellido" placeholder="Ejemplo:Perez" name="txtapellido"
                                            value="{{$fila->apellido_paciente}}" required > 
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" id="inputfecnac" name="txtfecnac"
                                            value="{{$fila->fecha_nacimiento_paciente}}" required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left">Telefono</label>
                                        <input type="text" class="form-control form-control-sm" id="inputtelefono" placeholder="Ejemplo:66666666" name="txttelefono" 
                                            value="{{$fila->telefono_paciente}}"  >
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left" for="example-email">Correo</label>
                                        <div class="input-group mb-15"> <span class="input-group-addon">@</span>
                                            <input type="email" class="form-control" placeholder="Ejemplo:juan@gmail.com" 
                                               name="txtemail" value="{{$fila->email_paciente}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label mb-10 text-left">Comentarios</label>
                                        <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" name="txtComentario" rows="2">{{$fila->comentario_paciente}}</textarea>
                                    </div>
                                    <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">
                                    <input type="hidden" name="txtid" id="txtid" class="form-control form-control-sm" value="{{$fila->id}}">
                                    <div class="modal-footer">                                        
                                        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
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
