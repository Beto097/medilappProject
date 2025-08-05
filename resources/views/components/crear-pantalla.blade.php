
<div class="row" style="padding-top: 15px">      
    <div class="form-group col-md-6">
        <label for="">Nombre</label>
        <input type="text" class="form-control" id="" placeholder="Ejemplo: Crear Usuario"  value="{{old('txtNombre')}}" name="txtNombre" required>
    </div>
    <div class="form-group col-md-6">
        <label for="">URL</label>
        <input type="text" class="form-control" id="" placeholder="Ejemplo: usuario/create" value="{{old('txtUrl')}}" name="txtUrl" required>
    </div>
    <div class="form-group col-md-12">
        <label for="">Asignar a:</label>
        <select class="form-control" name="txtPadre" id="">
        <option value="0">Raiz</option>
        @foreach ($pantallas as $padre)
            <option value="{{$padre->id}}">{{$padre->nombre_pantalla}}</option>
        @endforeach                     
        
        </select>
    </div>
    <div class="form-group col-md-4 text-center">
        <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="txtEstado" id="" value="1" checked>
        Mostrar en el Menu?
        </label>
    </div>

    
</div>

<div class="modal-footer">                                        
    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Agregar Pantalla</button>
</div>