<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewCaracteristicaExamenModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Caracteristica de Examen</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('caracteristica_examen.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label for="">Nombre caracteristica:</label>
                                        <input type="text" class="form-control" id="" placeholder="" name="txtNombre" required> 
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label for="">Unidad:</label>
                                        <input type="text" class="form-control" id="" placeholder="" name="txtUnidad" > 
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label for="exampleFormControlTextarea1">Valor:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="txtValor" rows="5"></textarea>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1' checked>
                                        <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                                    </div>
                                    
                                </div>                                


                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Agregar Caracteristica</button>
                                </div>
                                
                
                            </form>
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>
