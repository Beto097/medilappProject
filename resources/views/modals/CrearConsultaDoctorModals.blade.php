<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="crearConsultaDoctorModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Crear Consulta</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('consulta.doctor')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                
                                <div class="row" style="padding-top: 15px">
                                    @if (!$fila->esMayor())  
                                        
                                        <div class="form-group col-md-6">
                                            <label for="">Nombre del Responsable</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: Jose Ramos"  value="{{old('txtNombre')}}" name="txtNombre" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Parentesco</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: Padre" value="{{old('txtParentesco')}}" name="txtParentesco" required>
                                        </div>                                    
                                    @endif

                                    <x-lista-medicos/>
                                    <div class="form-group col-md-6">
                                        <label for="">Motivo de visita</label>
                                        <select class="form-control" name="selectMotivo" id="selectMotivo{{$fila->id}}" required onchange="toggleOtroMotivo({{$fila->id}})">
                                            <option value="Control de Salud">Control de Salud</option>
                                            <option value="Consulta regular">Consulta regular</option>
                                            <option value="Certificado de buena salud">Certificado de buena salud</option>
                                            <option value="Receta médica">Receta - Orden</option>
                                            <option value="Incapacidad">Incapacidad</option>
                                            <option value="Certificado prenupcial">Certificado prenupcial</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Otro motivo</label>
                                        <input type="text" class="form-control" name="txtOtroMotivo" id="txtOtroMotivo{{$fila->id}}" placeholder="Especifique el motivo de consulta" disabled>
                                    </div>
                                </div>
                                <input type="hidden" name="tipo" value='
                                    @if ($fila->esMayor())  
                                        mayor
                                    @else
                                        menor
                                    @endif
                                '>
                                <input type="hidden" name="paciente_id" value={{$fila->id}}>
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearModal2" onclick="return validarSeleccion()"  class="btn btn-primary text-left">Crear Consulta</button>
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

<script>
function toggleOtroMotivo(pacienteId) {
    const selectMotivo = document.getElementById('selectMotivo' + pacienteId);
    const txtOtroMotivo = document.getElementById('txtOtroMotivo' + pacienteId);
    
    if (selectMotivo.value === 'Otro') {
        txtOtroMotivo.disabled = false;
        txtOtroMotivo.required = true;
        txtOtroMotivo.focus();
    } else {
        txtOtroMotivo.disabled = true;
        txtOtroMotivo.required = false;
        txtOtroMotivo.value = '';
    }
}

function validarSeleccion() {
    // Función existente - mantener la lógica original si existe
    return true;
}
</script>