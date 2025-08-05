<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="reasignarConsultaDoctorModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Reasignar Consulta</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('consulta.reasignar')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                
                                <div class="row" style="padding-top: 15px">
                                  

                                    <x-lista-medicos/>
                                    
                                </div>
                            
                                <input type="hidden" name="consulta_id" value={{$fila->id}}>
                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearModal2"  class="btn btn-primary text-left">Reasignar Consulta</button>
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