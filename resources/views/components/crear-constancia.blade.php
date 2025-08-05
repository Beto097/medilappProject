<div class="row" style="padding-top: 15px; margin-left: 10px">      
   
    <div class="form-group col-md-4">
        <label for="" name="hora_inicio">Hora de entrada:</label>
        <input type="time" class="form-control" name="hora_inicio" required/>
    </div>
    <div class="form-group col-md-4">
        <label for="" name="hora_fin">Hora de salida:</label>
        <input type="time" class="form-control" name="hora_fin" required/>
    </div> 
    <div class="form-group col-md-4">
        <label for="" name="fecha_constancia">Fecha:</label>
        <input type="date" class="form-control" name="fecha_constancia" value="{{ date('Y-m-d') }}" required/>
    </div>
</div>

<div class="modal-footer">  
    <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$consulta->id}}">                                      
    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Crear</button>
</div>