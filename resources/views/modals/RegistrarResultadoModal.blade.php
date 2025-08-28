<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="RegistrarResultadoModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">
                    Registrar Resultado - {{$fila->examen->nombre_examen ?? 'Examen'}}
                </h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <!-- Información del examen -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <h6>{{$fila->examen->tipo_examen->nombre_tipo_examen ?? 'Tipo de Examen'}}</h6>
                            </div>
                        </div>

                        <div class="form-wrap">
                            <form action="{{route('insertar.resultados', ['id' => $fila->id])}}" method="POST" role="form" autocomplete="off" id="formResultados{{$fila->id}}">
                                @csrf

                                <!-- Campos dinámicos para características del examen -->
                                @if(isset($fila->examen) && isset($fila->examen->examen_caracteristica_examen) && $fila->examen->examen_caracteristica_examen->count() > 0)
                                    <!-- Encabezados de columna -->
                                    @if($fila->examen->tiene_referencia == '1')
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>PRUEBA</strong>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>RESULTADO</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <strong>UNIDAD</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>VALOR DE REFERENCIA</strong>
                                            </div>
                                        </div>
                                        <hr class="mb-3">
                                    @else
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>PRUEBA</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>RESULTADO</strong>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                        <hr class="mb-3">
                                    @endif

                                    @foreach($fila->examen->examen_caracteristica_examen as $caracteristica_examen)
                                        <div class="row mb-2">
                                            @if($fila->examen->tiene_referencia == '1')
                                                <div class="col-md-3">
                                                    <label class="form-label">{{$caracteristica_examen->caracteristica_examen->nombre_caracteristica_examen}}</label>
                                                </div>
                                                <div class="col-md-3">
                                                    @if($caracteristica_examen->caracteristica_examen->es_obligatorio == '1')
                                                        <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]" required>
                                                    @else
                                                        <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]">
                                                    @endif
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="text-muted">{{$caracteristica_examen->caracteristica_examen->unidad_caracteristica_examen ?? ''}}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-muted">{!!$caracteristica_examen->caracteristica_examen->valor_referencia_caracteristica_examen ?? ''!!}</span>
                                                </div>
                                            @else
                                                <div class="col-md-4">
                                                    <label class="form-label">{{$caracteristica_examen->caracteristica_examen->nombre_caracteristica_examen}}</label>
                                                </div>
                                                <div class="col-md-4">
                                                    @if($caracteristica_examen->caracteristica_examen->es_obligatorio == '1')
                                                        <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]" required>
                                                    @else
                                                        <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]">
                                                    @endif
                                                </div>
                                                <div class="col-md-4"></div>
                                            @endif
                                            <input type="hidden" name="caracteristica_id[]" value="{{$caracteristica_examen->caracteristica_examen->id}}">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-warning">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                No hay características configuradas para este examen. Por favor, contacte al administrador.
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Checkbox para observaciones -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="observaciones{{$fila->id}}" name="Observaciones" onclick="toggleObservaciones({{$fila->id}});">
                                            <label class="custom-control-label" for="observaciones{{$fila->id}}">Desea Agregar Observaciones</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo de observaciones (oculto por defecto) -->
                                <div class="row mt-2" style="display: none;" id="observacionesDiv{{$fila->id}}">
                                    <div class="col-md-3">
                                        <label><strong>Observaciones:</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="txtObservaciones" rows="3" placeholder="Ingrese sus observaciones aquí..."></textarea>
                                    </div>
                                </div>

                                <!-- Campo oculto con el ID del examen -->
                                <input type="hidden" name="txtExamenOrdenLaboratorioId" value="{{$fila->id}}">

                                <!-- Detalle del examen -->
                                @if(isset($fila->examen) && $fila->examen->detalle_examen)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    {!!$fila->examen->detalle_examen!!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Guardar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleObservaciones(filaId) {
    const checkbox = document.getElementById('observaciones' + filaId);
    const observacionesDiv = document.getElementById('observacionesDiv' + filaId);
    
    if (checkbox.checked) {
        observacionesDiv.style.display = 'block';
    } else {
        observacionesDiv.style.display = 'none';
    }
}

// Validación del formulario
$(document).ready(function() {
    $('[id^="formResultados"]').on('submit', function(e) {
        let valid = true;
        let requiredFields = $(this).find('input[required], textarea[required]');
        
        requiredFields.each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor complete todos los campos requeridos');
        }
    });
});
</script>