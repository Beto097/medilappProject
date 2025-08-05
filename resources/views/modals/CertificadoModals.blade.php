<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewCertificadoModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Generar certificado de buena salud</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form id="formCrearCertificado" action="{{ route('certificado.insert') }}" method="POST" role="form">
                                @csrf
                                <x-crear-certificado :resultado="$consulta" /> 
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