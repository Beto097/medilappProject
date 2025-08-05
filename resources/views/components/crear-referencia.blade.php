
<div class="row" style="padding-top: 15px">      
    <div class="form-group col-md-6">
        <label for="">Servicio Medico al que Refiere:</label>
        <input type="text" class="form-control" id="" placeholder="Ejemplo: CSS"  value="{{old('RefiereA')}}" name="RefiereA" required>
    </div>
    <div class="form-group col-md-6">
        <label for="">Tipo de Referencia:</label>
        <select class="form-control" name="tipoR" id="">
            <option value="1" selected>Consulta Externa</option>
            <option value="2" >Urgencia</option>          
        
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="">Motivo de Referencia:</label>
        <select class="form-control" name="motivoR" id="motivoR">
            <option value="1" selected>Servicio No Ofertado o No disponible</option>
            <option value="2" >Ausencia de Profesional</option>          
            <option value="3" >Falta de Equipo</option> 
            <option value="4" >Falta de Insumo</option> 
            <option value="5" >Caso de Actividades</option>
            <option value="6" >Otro, Cual</option> 
        </select>
    </div>
    <!-- Input oculto al inicio -->
    <div class="form-group col-md-6" id="otroMotivoDiv" style="display: none;">
        <label for="">Otro Motivo:</label>
        <input type="text" class="form-control" name="otroMotivo" placeholder="Especifique el motivo">
    </div>
    <script>
        document.getElementById('motivoR').addEventListener('change', function() {
            const otroDiv = document.getElementById('otroMotivoDiv');
            if (this.value === '6') {
                otroDiv.style.display = 'block';
            } else {
                otroDiv.style.display = 'none';
            }
        });
    </script>

    
</div>

<div class="modal-footer">  
    <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$consulta->id}}">                                      
    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Crear</button>
</div>