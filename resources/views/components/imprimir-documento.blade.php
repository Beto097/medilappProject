<div class="form-group col-md-12 col-sm-12 col-xs-12">                                        
    <div class="input-group mb-3">
        <label for="">Seleccione el documento a imprimir</label>
        <div class="col-sm-12">
            <select class="form-control" name="selectDocumento" id="selectDocumento{{ $consulta ? $consulta->id : '' }}" onchange="console.log('Select changed to:', this.value); toggleButtons(this); if(this.value === 'receta') mostrarBotones({{ $consulta ? $consulta->id : '' }});">
                
                @if ($consulta && $consulta->tieneCertificado())
                    <option value="certificado">Certificado</option>
                @endif
                @if ($consulta && $consulta->tieneConstancia())
                    <option value="constancia">Constancia</option>
                @endif
                @if ($consulta && $consulta->tieneReferencia())
                    <option value="referencia">Referencia</option>
                @endif
                @if ($consulta && $consulta->tieneReceta())
                    <option value="receta">Receta</option>
                @endif
                
            </select>
        </div>
    </div>
    
</div>
<div class="modal-footer">  
    <input type="hidden" name="txtId" id="txtId{{ $consulta ? $consulta->id : '' }}" class="form-control form-control-sm" value="{{ $consulta ? $consulta->id : '' }}">                                      
    <button type="button" id="btnImprimirViejo{{ $consulta ? $consulta->id : '' }}" class="btn btn-warning text-left" style="display: @if($consulta && $consulta->tieneReceta() && !$consulta->tieneCertificado() && !$consulta->tieneConstancia() && !$consulta->tieneReferencia()) inline-block @else none @endif;" onclick="imprimirRecetaOld({{ $consulta ? $consulta->id : '' }})">Imprimir Viejo</button>
    <button type="button" id="btnCrearModal2{{ $consulta ? $consulta->id : '' }}" class="btn btn-primary text-left" onclick="imprimirDocumento({{ $consulta ? $consulta->id : '' }})">Imprimir</button>
    <button type="button" id="btnGuardarReceta{{ $consulta ? $consulta->id : '' }}" class="btn btn-success text-left" style="display: @if($consulta && $consulta->tieneReceta() && !$consulta->tieneCertificado() && !$consulta->tieneConstancia() && !$consulta->tieneReferencia()) inline-block @else none @endif;" onclick="guardarReceta({{ $consulta ? $consulta->id : '' }})">Guardar</button>
    
</div>

<script>
function toggleButtons(selectElement) {
    console.log('toggleButtons called with:', selectElement);
    console.log('Select value:', selectElement ? selectElement.value : 'no element');
    
    // Extraer consultaId del ID del select
    const consultaId = selectElement ? selectElement.id.replace('selectDocumento', '') : '';
    console.log('ConsultaId extraído:', consultaId);
    
    // Búsqueda con IDs únicos
    const btnGuardar = document.getElementById('btnGuardarReceta' + consultaId);
    const btnImprimirViejo = document.getElementById('btnImprimirViejo' + consultaId);
    
    console.log('Botón Guardar encontrado:', btnGuardar);
    console.log('Botón Imprimir Viejo encontrado:', btnImprimirViejo);
    
    if (btnGuardar && btnImprimirViejo) {
        if (selectElement && selectElement.value === 'receta') {
            btnGuardar.style.display = 'inline-block';
            btnImprimirViejo.style.display = 'inline-block';
            console.log('✅ Mostrando botones para receta');
        } else {
            btnGuardar.style.display = 'none';
            btnImprimirViejo.style.display = 'none';
            console.log('❌ Ocultando botones');
        }
    } else {
        console.log('❌ No se encontraron todos los botones');
    }
}

// Función para mostrar botones con consultaId específico
function mostrarBotones(consultaId) {
    const btnGuardar = document.getElementById('btnGuardarReceta' + consultaId);
    const btnImprimirViejo = document.getElementById('btnImprimirViejo' + consultaId);
    
    if (btnGuardar) btnGuardar.style.display = 'inline-block';
    if (btnImprimirViejo) btnImprimirViejo.style.display = 'inline-block';
    
    console.log('Botones mostrados manualmente para consulta:', consultaId);
}

function guardarReceta(consultaId) {
    const selectDocumento = document.getElementById('selectDocumento' + consultaId);
    
    if (!selectDocumento || !consultaId) {
        alert('Error: No se pudo encontrar los datos necesarios.');
        return;
    }
    
    // Verificar que se haya seleccionado receta
    if (selectDocumento.value !== 'receta') {
        alert('Esta función solo está disponible para recetas.');
        return;
    }
    
    console.log('Abriendo PDF simple en nueva ventana...');
    
    // Abrir directamente la URL del PDF simple
    const url = '/receta/print/' + consultaId;
    window.open(url, '_blank');
}

function imprimirDocumento(consultaId) {
    const selectDocumento = document.getElementById('selectDocumento' + consultaId);
    
    if (!selectDocumento || !consultaId) {
        alert('Error: No se pudo encontrar los datos necesarios.');
        return;
    }
    
    // Verificar que se haya seleccionado algo
    if (!selectDocumento.value) {
        alert('Debe seleccionar un documento para imprimir.');
        return;
    }
    
    console.log('Abriendo PDF en nueva ventana...');
    
    // Determinar la URL según el tipo de documento seleccionado
    let url;
    switch(selectDocumento.value) {
        case 'receta':
            url = '/receta/printCompleto/' + consultaId;
            break;
        case 'certificado':
            url = '/certificado/print/' + consultaId;
            break;
        case 'constancia':
            url = '/constancia/print/' + consultaId;
            break;
        case 'referencia':
            url = '/referencia/print/' + consultaId;
            break;
        default:
            alert('Tipo de documento no válido.');
            return;
    }
    
    // Abrir en nueva ventana
    window.open(url, '_blank');
}

function imprimirRecetaOld(consultaId) {
    if (!consultaId) {
        alert('Error: No se pudo encontrar el ID de la consulta.');
        return;
    }
    
    // Crear la URL directamente para el PDF viejo
    const url = '/receta/printOld/' + consultaId;
    
    // Abrir en nueva ventana
    window.open(url, '_blank');
}

// Debugging - ejecutar cuando carga la página
$(document).ready(function() {
    console.log('Document ready ejecutado');
    
    // Función para verificar y mostrar botones para un consultaId específico
    function checkAndShowButtons(consultaId) {
        const selectElement = document.getElementById('selectDocumento' + consultaId);
        if (selectElement) {
            console.log('Verificando valor actual del select para consulta', consultaId, ':', selectElement.value);
            
            // Contar opciones disponibles
            const opciones = selectElement.querySelectorAll('option');
            const esUnicaOpcion = opciones.length === 1;
            
            if (selectElement.value === 'receta' && esUnicaOpcion) {
                console.log('Receta es la única opción disponible, mostrando botones...');
                mostrarBotones(consultaId);
            }
            
            toggleButtons(selectElement);
        }
    }
    
    // Para modales dinámicos - usando el patrón de ID con consultaId
    $('[id^="imprimirModal"]').on('shown.bs.modal', function () {
        const modalId = $(this).attr('id');
        console.log('Modal dinámico abierto:', modalId);
        
        // Extraer consultaId del modal ID si es posible
        const consultaIdMatch = modalId.match(/\d+/);
        if (consultaIdMatch) {
            const consultaId = consultaIdMatch[0];
            setTimeout(() => checkAndShowButtons(consultaId), 200);
        } else {
            // Si no se puede extraer, intentar buscar el select en el modal
            const selectInModal = $(this).find('[id^="selectDocumento"]')[0];
            if (selectInModal) {
                const consultaId = selectInModal.id.replace('selectDocumento', '');
                setTimeout(() => checkAndShowButtons(consultaId), 200);
            }
        }
    });
    
    // Ejecutar también cuando se detecta que el DOM está listo
    setTimeout(function() {
        console.log('=== DEBUGGING INFO ===');
        // Buscar todos los selects de documento en la página
        const allSelects = document.querySelectorAll('[id^="selectDocumento"]');
        allSelects.forEach(select => {
            const consultaId = select.id.replace('selectDocumento', '');
            console.log('Found select for consulta:', consultaId);
            checkAndShowButtons(consultaId);
        });
    }, 300);
});
</script>