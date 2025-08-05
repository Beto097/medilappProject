<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewSucursalModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Sucursal</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('sucursal.insert')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                <x-crear-sucursal/>                               
                                
                
                            </form>
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>
