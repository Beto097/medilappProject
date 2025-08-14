<div id="addNewMedicoModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-valmar">
                <h5 class="modal-title">
                    <span class="mr-2 text-white">•</span>
                    <span class="font-weight-bold text-white">Agregar Médico</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('medico.insert')}}" method="POST" role="form" autocomplete="off" id="formAgregarMedico">
                                @csrf
                                
                                <div class="row" style="padding-top: 15px">
                                    <!-- Información Personal -->
                                    <div class="col-12 mb-3">
                                        <h6 class="text-muted border-bottom pb-2">
                                            <span class="mr-2">•</span>Información Personal
                                        </h6>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="txtNombreMedico" class="font-weight-semibold">
                                            Nombre del Doctor <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="txtNombreMedico" 
                                               placeholder="Ej: Dr. Juan Carlos Pérez" 
                                               name="txtNombre"
                                               value="{{ old('txtNombre') }}"
                                               required>
                                        <small class="form-text text-muted">Ingrese el nombre completo del médico</small>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="txtRegistro2" class="font-weight-semibold">
                                            Número de Registro <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="txtRegistro2" 
                                               placeholder="Ej: 1538540" 
                                               onfocusout="validarRegistro2()" 
                                               name="txtNumero" 
                                               value="{{ old('txtNumero') }}"
                                               required>
                                        <small id="AlertaRegistro2" class="form-text text-muted"></small>
                                        <small id="AlertaMedico2" class="form-text text-muted"></small>
                                    </div>

                                    <!-- Información de Contacto -->
                                    <div class="col-12 mb-3 mt-3">
                                        <h6 class="text-muted border-bottom pb-2">
                                            <span class="mr-2">•</span>Información de Contacto
                                        </h6>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="txtEmailMedico" class="font-weight-semibold">
                                            Correo Electrónico
                                        </label>
                                        <div class="input-group">
                                            <input type="email" 
                                                   class="form-control" 
                                                   id="txtEmailMedico"
                                                   placeholder="doctor@ejemplo.com" 
                                                   name="txtEmail"
                                                   value="{{ old('txtEmail') }}">
                                        </div>
                                        <small class="form-text text-muted">Para notificaciones y comunicación</small>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="txtTelefonoMedico" class="font-weight-semibold">
                                            Teléfono
                                        </label>
                                        <div class="input-group">
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="txtTelefonoMedico"
                                                   placeholder="64987858" 
                                                   name="txtTelefono" 
                                                   value="{{ old('txtTelefono') }}">
                                        </div>
                                        <small class="form-text text-muted">Número de contacto del médico</small>
                                    </div>
                                </div>

                                <!-- Campos ocultos -->
                                <input type="hidden" name="esModal" value="3">                 
                                @if(Request::url() === env('APP_URL').'/ordenlaboratorio/create')
                                    <input type="hidden" name="esModal" value="2">
                                @endif
                                
                                <input type="hidden" 
                                       name="txtCedula" 
                                       id="txtCedula3" 
                                       value="@if(isset($paciente->identificacion_paciente)){{$paciente->identificacion_paciente}}@endif">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" 
                        form="formAgregarMedico"
                        id="btnCrearMedicoModal" 
                        class="btn btn-primary">
                    Agregar Médico
                </button>
            </div>
        </div>
    </div>
</div>
