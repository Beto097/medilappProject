<div class="row">
    <div class="form-group col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10">Nombre de la Sucursal</label>
        <input type="text" class="form-control" id="inputEmail4" value="{{$fila->nombre_sucursal}}" placeholder="Ejemplo:Bella Vista" name="txtNombre"
            required>
    </div>       
    <div class="form-group col-md-6 col-sm-12 col-xs-12">
        <label class="control-label mb-10">Telefono</label>
        <div class="input-group mb-15"> <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input type="text" class="form-control" value="{{$fila->telefono_sucursal}}" placeholder="Ejemplo:64987858" aria-describedby="addon-wrapping"
            name="txtTelefono">
        </div>
    </div>
    <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$fila->id}}">
    <div class="modal-footer">                                        
        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
    </div>
</div>