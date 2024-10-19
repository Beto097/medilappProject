<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarTipoExamenModal{{$fila->id}}"  aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Tipo de Examen</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form action="{{route('tipoexamen.save')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">Tipo Examen</label>
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Ejemplo:Parasitología" name="txttipoexamen" value="{{$fila->nombre_tipo_examen}}" required>
                                    </div>                    
                                </div>
                                <br>
                                <br>
                                <input type="hidden" name="txtId" value="{{$fila->id}}">
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