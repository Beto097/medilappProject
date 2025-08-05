<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="imprimirModal{{$consulta->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Imprimir Documentos</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form id="formCrearConstancia{{$consulta->id}}" action="/imprimir/select" method="POST" role="form">
                                @csrf
                                <x-imprimir-documento :resultado="$consulta"/> 
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

