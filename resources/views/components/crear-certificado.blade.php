<div class="row justify-content-center" style="padding-top: 15px">
    <div class="form-group col-md-10 text-center">
        <label for="fecha_certificado">Fecha:</label>
        <input type="date" name="fecha_certificado"  required />
    </div>
</div>

<div class="modal-footer">  
    <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$consulta->id}}">                                      
    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Crear</button>
</div>