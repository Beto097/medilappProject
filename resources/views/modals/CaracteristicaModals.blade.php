<div   class="modal fade" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-valmar">

                <h5 class="modal-title"><span class="font-weight-bold text-white">Agregar Caracteristica</span></h5>

                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body text-left" >

                <form action= method="POST" role="form" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Nombre caracteristica:</label>
                            <input type="text" class="form-control" id="" placeholder="" name="txtNombre" required> 
                        </div>
    
                        <div class="form-group col-md-6">
                            <label for="">Unidad:</label>
                            <input type="text" class="form-control" id="" placeholder="" name="txtUnidad" >
                        </div>
    
                        
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlTextarea1">Valor:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="txtValor" rows="5"></textarea>
                        </div>
                        <br>
                        <br>
                    </div>
                    <div class="form-check col-md-12">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1' checked>
                        <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                      </div>
                      <br>
                    <div class="row justify-content-around"> 
                        <div class="col-8">

                        </div>
                        <div class="col-4"> 
                            <button type="submit" id="botoncrear" class="btn btn-info btn-lg"> Guardar</button>
                        </div>
                    </div>
                    
                </form>

            </div>

        </div>

    </div>

</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"  id="addNewCaracteristicaModal"   aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Crear Caracteristica de Examen</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">

                            <form action="{{route('caracteristica_examen.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Nombre caracteristica:</label>
                                        <input type="text" class="form-control" id="" placeholder="" name="txtNombre" required> 
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">Unidad:</label>
                                        <input type="text" class="form-control" id="" placeholder="" name="txtUnidad" >
                                    </div>
                
                                    
                                    <div class="form-group col-md-12">
                                        <label for="exampleFormControlTextarea1">Valor:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="txtValor" rows="5"></textarea>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                                <div class="form-check col-md-12">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtEsObligatorio" value='1' checked>
                                    <label class="form-check-label" for="exampleCheck1">¿Este campo es Obligatorio?</label>
                                </div>
                                <br>
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
