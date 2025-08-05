<div class="row">
    <div class="form-row">      
        <div class="form-group col-md-12">
            <label for="">Nombre</label>
            <input type="text" class="form-control" value="{{$fila->nombre_rol}}" id="" placeholder="Ejemplo: Crear Usuario" name="txtNombre" required>
        </div>
   
        
        <div class="form-group col-md-6 ">
            <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="txtEstado" id="" value="1" @if ($fila->tipo_rol ==1) checked @endif>
            Mostrar en el Menu?
            </label>
        </div>      
            
        

        
    </div>
    <input type="hidden" name="txtid" id="txtid" class="form-control form-control-sm" value="{{$fila->id}}">
    <div class="modal-footer">                                        
        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
    </div>
</div>