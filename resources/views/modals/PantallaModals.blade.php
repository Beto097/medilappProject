<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewPantallaModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Pantalla</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('pantalla.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-row">      
                                        <div class="form-group col-md-6">
                                            <label for="">Nombre</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: Crear Usuario" name="txtNombre" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">URL</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: usuario/create" name="txtUrl" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                          <label for="">Asignar a:</label>
                                          <select class="form-control" name="txtPadre" id="">
                                            <option value="0">Raiz</option>
                                            @foreach ($pantallas_padre as $padre)
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>