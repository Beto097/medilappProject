<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewRecetaModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl" style="max-width: 90%; width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Receta</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('receta.edit')}}" method="POST" role="form" >
                                @csrf
                                <x-editar-receta-medica :resultado='$consulta' />
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
