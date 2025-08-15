<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="habilitarMedicoModal{{$fila->id}}"  aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Habilitar Medico</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('medico.enable')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                
                                <x-habilitar-medico :resultado="$fila"/>
                                
                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
