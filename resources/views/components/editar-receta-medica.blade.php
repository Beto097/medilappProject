<div id="contenedorReceta">
    @foreach ($consulta->recetas as $filaReceta)
    
        <div class="row filaReceta {{ empty($tipo) ? '' : 'disabled-div' }}" id="filaReceta" style="padding-top: 15px" data-id="{{ $filaReceta->id }}"  >  
            <input type="hidden" name="txtFilaId[]" id="filaId" class="form-control form-control-sm" value="{{ $filaReceta->id }}">     
            <div class="form-group col-md-2">            
                <label for="">Tipo</label>                
                <div class="tipo-container" style="position: relative;">
                    <select class="form-control tipoSelect" name="txtTipo[]"> 
                        <option value="inyectable" @if($filaReceta->tipo=='inyectable') selected @endif>Inyectable</option>
                        <option value="oral" @if($filaReceta->tipo =='oral') selected @endif>Oral</option>  
                        <option value="topico"  @if($filaReceta->tipo =='topico') selected @endif>Tópico</option>
                        <option value="gotas" @if($filaReceta->tipo =='gotas') selected @endif>Gotas</option>
                        <option value="ampollas" @if($filaReceta->tipo =='ampollas') selected @endif>Ampollas</option>
                        <option value="jarabes" @if($filaReceta->tipo =='jarabes') selected @endif>Jarabes</option>
                        <option value="otro" @if(!in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes'])) selected @endif>Otro (escribir)</option>
                        @if(!in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes']))
                            <option value="{{$filaReceta->tipo}}" selected data-custom="true">{{$filaReceta->tipo}}</option>
                        @endif
                    </select>
                    <div class="tipo-custom-display" style="display: {{ in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes']) ? 'none' : 'block' }}; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: white; border: 1px solid #ccc; border-radius: 4px; padding: 6px 12px; pointer-events: none; z-index: 1;">
                        {{ !in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes']) ? $filaReceta->tipo : '' }}
                    </div>
                </div>
                <input type="text" class="form-control mt-2 tipoOtroInput" placeholder="Especifique el tipo" 
                       style="display:{{ in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes']) ? 'none' : 'block' }};"
                       value="{{ !in_array($filaReceta->tipo, ['inyectable','oral','topico','gotas','ampollas','jarabes']) ? $filaReceta->tipo : '' }}">
            </div>
            <div class="form-group col-md-3">
                <label for="">Medicamento</label>
                <input type="text" class="form-control" list="medicamentos" autocomplete="off" value="{{$filaReceta->medicamento}}" placeholder="Acetaminofen" name="txtMedicamento[]" required>
            </div>
            <div class="form-group col-md-2">
                <label for="">Dosis</label>
                <input type="text" class="form-control" placeholder="500mg" name="txtDosis[]" value="{{$filaReceta->dosis}}" required autocomplete="off">
            </div>
            <div class="form-group col-md-2">
                <label for="">Cantidad</label>
                <input type="text" class="form-control" placeholder="10 Tabletas" value="{{$filaReceta->cantidad}}" name="txtCantidad[]" required autocomplete="off">
            </div>
    
            <div class="form-group col-md-2">
                <label for="">Tratamiento</label>
                <input type="text" class="form-control" placeholder="una cada 8 horas" value="{{$filaReceta->tratamiento}}" name="txtTratamiento[]" required autocomplete="off">
            </div>

            @if (!isset($tipo))
                <div class="form-group col-md-1" style="padding-top: 1.5rem;">
                    <button type="button" class="btn btn-danger eliminarFila" onclick="eliminarFila2({{ $filaReceta->id }},this)"><i class="fa fa-trash"></i></button>
                </div>
            @endif
            
        </div>


    @endforeach 
    <datalist id="medicamentos">

        @foreach ($medicamentos as $medicamento)
            <option value="{{$medicamento}}">
        @endforeach
        
        

    </datalist>
</div>



<div class="row">
    <div class="form-group col-md-11">
        
    </div>
    @if (!isset($tipo))
        <div class="form-group col-md-1 " style="margin-left: -10px">
        
            <button type="button" id="sumarFila"  class="btn btn-primary text-left" onclick="agregarFila2()"><i id="iconoBoton" class="fa fa-plus"></i></button>
        
        </div>
    @endif
</div>

<div class="modal-footer">      
    <input type="hidden" name="txtIdConsulta" id="txtIdConsulta" class="form-control form-control-sm" value="{{$consulta->id}}"> 
    <input type="hidden" name="txtEliminarId" id="txtEliminarId" class="form-control form-control-sm"> 
    <input type="hidden" name="txtNumero" id="txtNumero" class="form-control form-control-sm" value="{{$filaReceta->numero}}"> 

    @if (!isset($tipo))
        <button type="submit" title="Guarda Receta" id="btnCrearModal2" name="accion" value="guardar" class="btn btn-primary text-left">Guardar</button>
    @endif


</div>

<style>
    .disabled-div {
        pointer-events: none; /* Evita clics e interacción */
        opacity: 0.9; /* Lo hace visualmente tenue */
    }
    .hidden {
        display: none; /* Oculta el div completamente */
    }
</style>

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
        input.addEventListener('input', function() { updateTipoValue(this); });
        input.addEventListener('keyup', function() { updateTipoValue(this); });
        input.addEventListener('blur', function() { updateTipoValue(this); });
        
        // Manejar el envío del formulario
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                updateTipoValue(input);
            });
        }
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
    
    document.addEventListener('blur', function(e) {
        if (e.target.classList.contains('tipoOtroInput')) {
            updateTipoValue(e.target);
        }
    }, true);
});
</script>

<style>
.disabled-div {
    pointer-events: none; /* Evita clics e interacción */
    opacity: 0.9; /* Lo hace visualmente tenue */
}
.hidden {
    display: none; /* Oculta el div completamente */
}

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


