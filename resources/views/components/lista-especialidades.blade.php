<div>
    <script src="https://unpkg.com/alpinejs" defer></script> 
    <div class="col-lg-6"  x-data="especialidadesData({{ json_encode($especialidades) }})">
        <div  class="col-lg-6">
            <label for="">Seleccione un tipo de especialidad</label> 
            <select class="form-control" name="selectTipo" id="tipo" x-model="tipoSeleccionado"> 
                <option value="">-- Selecciona --</option>           
                <template x-for="(especialidades, tipo) in especialidadesJson" :key="tipo">
                    <option :value="tipo" x-text="tipo"></option>
                </template>   
                
          
            </select>
        </div>
        <div class="col-lg-6" x-show="tipoSeleccionado">
            <label x-text="tipoSeleccionado"></label>    
            <select class="form-control" name="selectEspecialidad" id="especialidad" > 
                <option value="">-- Selecciona --</option>           
                <template x-for="item in especialidadesJson[tipoSeleccionado]" :key="item.especialidad">
                    <option :value="item.especialidad" x-text="item.especialidad"></option>
                    
                </template> 
            </select>  
        </div>

        
              
       
    </div>
   
   
        <div class="fallback">
            <input name="file dropzone" type="file" multiple="multiple">
        </div>
  
    
    <script>
        function especialidadesData(data) {
            return {
                especialidadesJson: data,
                tipoSeleccionado: ''
            }
        }
    </script>
</div>