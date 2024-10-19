<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarCaracteristicaModal{{$fila->id}}"   aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Caracteristica de Examen</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form action="{{ route('caracteristica_examen.save') }}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Nombre</label>
                                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Color" name="txtNombre" required value="{{$fila->nombre_caracteristica_examen}}">
                                    </div>
            
                                    <div class="form-group col-md-6">
                                        <label for="">Unidad</label>
                                        <input type="text" class="form-control" id="" placeholder="Ejemplo: mg/Dl" name="txtUnidad"  value="{{$fila->unidad_caracteristica_examen}}">
                                    </div>
            
                                    
                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Valor:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="txtValor" rows="5" >{!!$valores_referencia[$fila->id]!!}</textarea>
                                    </div>
                                </div>
                                @if ($fila->es_obligatorio=='1')
                                    <div class="form-check col-md-12">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1' checked>
                                        <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                                    </div>
                                @else
                                    <div class="form-check col-md-12">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1'>
                                        <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                                    </div>
                                @endif
                                
                                  
                                <input type="hidden" name="txtId" id="input" class="form-control" value="{{ $fila->id }}">
            
                                
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>

