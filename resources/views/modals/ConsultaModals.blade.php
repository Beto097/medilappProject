<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewConsultaModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Crear Consulta</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('consulta.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-2 col-sm-12 col-xs-12">                                    
   
                                    </div>                                
    
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                        <label class="control-label mb-10 text-left">Cédula</label>
                                        <input type="text" class="form-control"  name="txtCedula" id="txtCedula" placeholder="Ejemplo:8-888-8888"  onfocusout="validarCedula()"
                                            value="{{old ('txtCedula')}}" required>
                                        <small id="AlertaCedula2" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group col-md-1 col-sm-12 col-xs-12" style="padding-top: 2rem">
                                        <a class="btn btn-primary btn-sm"  title="buscar paciente"><i class="fa fa-search"></i></a> 
                                    </div>
                                    <div id="contenidoMenor" class="hidden">
                                        
                                        <div class="form-group col-md-6">
                                            <label for="">Nombre del Responsable</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: Jose Ramos"  value="{{old('txtNombre')}}" name="txtNombre" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Parentesco</label>
                                            <input type="text" class="form-control" id="" placeholder="Ejemplo: Padre" value="{{old('txtParentesco')}}" name="txtParentesco">
                                        </div>   
                                    </div>
                                </div>
                                <div id="divBtn" class="hidden">
                                    <div  class="modal-footer ">                                        
                                        <button  type="submit" id="btnCrearModal2" class="btn btn-primary text-left">Crear Consulta</button>
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