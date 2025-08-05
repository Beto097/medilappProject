<div class="row">
    <div class="form-row">      
        <div class="form-group col-md-6">
            <label for="">Nombre</label>
            <input type="text" class="form-control" value="{{$fila->nombre_pantalla}}" id="" placeholder="Ejemplo: Crear Usuario" name="txtNombre" required>
        </div>
        <div class="form-group col-md-6">
            <label for="">URL</label>
            <input type="text" class="form-control" value="{{$fila->url_pantalla}}" id="" placeholder="Ejemplo: usuario/create" name="txtUrl" required>
        </div>
        <div class="form-group col-md-12">
            <label for="">Asignar a:</label>
            <select class="form-control" name="txtPadre" id="">
              <option value="0">Raiz</option>
              @foreach ($pantallas as $padre)

                @if ($padre->id == $fila->padre)
                    <option value="{{$padre->id}}" selected>{{$padre->nombre_pantalla}}</option>
                @else
                    <option value="{{$padre->id}}">{{$padre->nombre_pantalla}}</option>
                @endif
                
              @endforeach                     
              
            </select>
        </div>
        @if ($fila->estado_pantalla ==1)
            <div class="form-group col-md-4 text-center">
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="txtEstado" id="" value="1" checked>
                Mostrar en el Menu?
                </label>
            </div>
        @else
            <div class="form-group col-md-4 text-center">
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="txtEstado" id="" value="1">
                Mostrar en el Menu?
                </label>
            </div>
            
        @endif

        
    </div>
    <input type="hidden" name="esModal" id="esModal" class="form-control form-control-sm" value="2">
    <input type="hidden" name="txtid" id="txtid" class="form-control form-control-sm" value="{{$fila->id}}">
    <div class="modal-footer">                                        
        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
    </div>
</div>