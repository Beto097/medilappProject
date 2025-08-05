

<div id="contenedorReceta">
    <div class="row filaReceta" id="filaReceta" style="padding-top: 15px">      
        <div class="form-group col-md-2">            
            <label for="">Tipo</label> 
            <div class="tipo-container" style="position: relative;">
                <select class="form-control tipoSelect" name="txtTipo[]">               
                    <option value="inyectable">Inyectable</option>
                    <option value="oral">Oral</option>
                    <option value="topico">Tópico</option>
                    <option value="gotas">Gotas</option>
                    <option value="ampollas">Ampollas</option>
                    <option value="jarabes">Jarabes</option>
                    <option value="otro">Otro (escribir)</option> 
                </select>
                <div class="tipo-custom-display" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: white; border: 1px solid #ccc; border-radius: 4px; padding: 6px 12px; pointer-events: none; z-index: 1;">
                </div>
            </div>
            <input type="text" class="form-control mt-2 tipoOtroInput" placeholder="Especifique el tipo" style="display:none;">
        </div>
        <div class="form-group col-md-3">
            <label for="">Medicamento</label>
            <input type="text" class="form-control" list="medicamentos" autocomplete="off" placeholder="Acetaminofen" name="txtMedicamento[]" required>
        </div>
        <div class="form-group col-md-2">
            <label for="">Dosis</label>
            <input type="text" class="form-control" placeholder="500mg" name="txtDosis[]" required autocomplete="off">
        </div>
        <div class="form-group col-md-2">
            <label for="">Cantidad</label>
            <input type="text" class="form-control" placeholder="10 Tabletas" name="txtCantidad[]" required autocomplete="off">
        </div>

        <div class="form-group col-md-2">
            <label for="">Tratamiento</label>
            <input type="text" class="form-control" placeholder="una cada 8 horas" name="txtTratamiento[]" required autocomplete="off">
        </div>
        <div class="form-group col-md-1" style="padding-top: 1.5rem; margin-left: -10px">
            <button type="button" class="btn btn-danger eliminarFila" style="display: none;"><i class="fa fa-trash"></i></button>
        </div>
        
    </div>
    <datalist id="medicamentos">

        @foreach ($medicamentos as $medicamento)
            <option value="{{$medicamento}}">
        @endforeach
        
        

    </datalist>

</div>


<div class="row">
    <div class="form-group col-md-11" style="margin-left: -10px">
        
    </div>
    <div class="form-group col-md-1 ">
        <button type="button" id="sumarFila"  class="btn btn-primary text-left" onclick="agregarFila()"><i id="iconoBoton" class="fa fa-plus"></i></button>
       
    </div>
</div>

<div class="modal-footer">      
    <input type="hidden" name="txtIdConsulta" id="txtIdConsulta" class="form-control form-control-sm" value="{{$consulta->id}}">                               


    @if (!isset($tipo))
        <button type="submit" title="Guarda Receta" id="btnCrearModal2" name="accion" value="guardar" class="btn btn-primary text-left">Guardar</button>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para manejar el cambio en el select de tipo
    function handleTipoChange(selectElement) {
        const container = selectElement.closest('.tipo-container') || selectElement.parentElement;
        const filaReceta = selectElement.closest('.filaReceta');
        const tipoOtroInput = filaReceta.querySelector('.tipoOtroInput');
        const customDisplay = container.querySelector('.tipo-custom-display');
        
        if (selectElement.value === 'otro') {
            // Mostrar el campo "Otro"
            tipoOtroInput.style.display = 'block';
            tipoOtroInput.required = true;
        } else {
            // Ocultar el campo "Otro" y el display personalizado
            tipoOtroInput.style.display = 'none';
            tipoOtroInput.value = ''; // Limpiar el campo
            tipoOtroInput.required = false;
            
            if (customDisplay) {
                customDisplay.style.display = 'none';
            }
        }
    }
    
    // Función para actualizar el valor del select con el texto personalizado
    function updateTipoValue(input) {
        const filaReceta = input.closest('.filaReceta');
        const tipoSelect = filaReceta.querySelector('.tipoSelect');
        const container = tipoSelect.closest('.tipo-container') || tipoSelect.parentElement;
        const customDisplay = container.querySelector('.tipo-custom-display');
        
        // Solo proceder si el select está en modo "otro"
        if (tipoSelect.value === 'otro' || tipoSelect.querySelector('option[data-custom="true"]:checked')) {
            if (input.value.trim() !== '') {
                // Crear o actualizar una opción hidden con el valor personalizado
                let customOption = tipoSelect.querySelector('option[data-custom="true"]');
                if (!customOption) {
                    customOption = document.createElement('option');
                    customOption.setAttribute('data-custom', 'true');
                    tipoSelect.appendChild(customOption);
                }
                
                // Asignar el valor personalizado y seleccionarlo
                customOption.value = input.value.trim();
                customOption.textContent = input.value.trim();
                customOption.selected = true;
                
                // Deseleccionar la opción "otro"
                const otroOption = tipoSelect.querySelector('option[value="otro"]');
                if (otroOption) {
                    otroOption.selected = false;
                }
                
                // Mostrar el texto personalizado sobre el select
                if (customDisplay) {
                    customDisplay.textContent = input.value.trim();
                    customDisplay.style.display = 'block';
                }
            } else {
                // Si el campo está vacío, volver a seleccionar "otro"
                const otroOption = tipoSelect.querySelector('option[value="otro"]');
                if (otroOption) {
                    otroOption.selected = true;
                }
                
                // Ocultar el display personalizado
                if (customDisplay) {
                    customDisplay.style.display = 'none';
                }
                
                // Remover la opción personalizada si existe
                const customOption = tipoSelect.querySelector('option[data-custom="true"]');
                if (customOption) {
                    customOption.remove();
                }
            }
        }
    }
    
    // Inicializar estados al cargar la página
    document.querySelectorAll('.filaReceta').forEach(function(fila) {
        const tipoSelect = fila.querySelector('.tipoSelect');
        const tipoOtroInput = fila.querySelector('.tipoOtroInput');
        
        if (tipoSelect && tipoOtroInput) {
            // Si el input tiene valor y está visible, actualizar el select
            if (tipoOtroInput.style.display === 'block' && tipoOtroInput.value.trim() !== '') {
                updateTipoValue(tipoOtroInput);
            }
        }
    });
    
    // Agregar event listener a todos los selects de tipo existentes
    document.querySelectorAll('.tipoSelect').forEach(function(select) {
        select.addEventListener('change', function() {
            handleTipoChange(this);
        });
    });
    
    // Agregar event listener a todos los inputs de tipo personalizado
    document.querySelectorAll('.tipoOtroInput').forEach(function(input) {
        input.addEventListener('input', function() {
            updateTipoValue(this);
        });
        input.addEventListener('keyup', function() {
            updateTipoValue(this);
        });
        input.addEventListener('blur', function() {
            updateTipoValue(this);
        });
    });
    
    // Para futuras filas que se agreguen dinámicamente
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('tipoSelect')) {
            handleTipoChange(e.target);
        }
    });
    
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('tipoOtroInput')) {
            updateTipoValue(e.target);
        }
    });
    
    document.addEventListener('keyup', function(e) {
        if (e.target.classList.contains('tipoOtroInput')) {
            updateTipoValue(e.target);
        }
    });
    
    // Asegurar que antes del envío del formulario se actualicen los valores
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            document.querySelectorAll('.tipoOtroInput').forEach(function(input) {
                if (input.style.display !== 'none' && input.value.trim() !== '') {
                    updateTipoValue(input);
                }
            });
        });
    });
});
</script>

<style>
/* Mejorar la visualización de selects con texto largo */
.tipoSelect {
    width: 100% !important;
    min-width: 120px;
    overflow: visible;
}

.tipoSelect option {
    white-space: nowrap;
    overflow: visible;
    text-overflow: clip;
    padding: 5px;
}

/* Ajustar el ancho específicamente del campo tipo */
.form-group:has(.tipoSelect) {
    min-width: 140px;
}
</style>

