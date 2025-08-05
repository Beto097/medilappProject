
<div class="row" style="padding-top: 15px">      
    <div class="form-group col-md-12">
        <label for="">Nombre</label>
        <input type="text" class="form-control" id="" placeholder="Ejemplo: Crear Usuario"  value="{{old('txtNombre')}}" name="txtNombre" required>
    </div>

    <div class="form-group col-md-6">
        <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="txtTipo" id="" value="1" checked>
            Puede ver datos Eliminados?
        </label>
    </div>


    
</div>

<div class="modal-footer">                                        
    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Agregar Rol</button>
</div>
