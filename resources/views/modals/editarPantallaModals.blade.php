<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarPantallaModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Pantalla</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('pantalla.save')}}" method="POST" role="form" autocomplete="off">  
                                @csrf
                                <input type="hidden" id="txtCedulaOld" value="{{$fila->identificacion_paciente}}">
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
                                              @foreach ($pantallas_padre as $padre)
                    
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
                                    <input type="hidden" name="txtId" id="txtId" class="form-control form-control-sm" value="{{$fila->id}}">
                                    <div class="modal-footer">                                        
                                        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
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
