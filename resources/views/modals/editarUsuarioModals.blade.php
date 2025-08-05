<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarUsuarioModal{{$fila->id}}"  aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Usuario</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('usuario.save')}}" method="POST" role="form" autocomplete="off">
                                @csrf
                                
                                <x-editar-usuario :resultado="$fila"/>
                                
                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
