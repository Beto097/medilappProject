<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewFileModal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Cargar Archivo</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('archivo.insert')}}" method="POST" role="form" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <!-- Campo hidden para ayudar con el límite de tamaño -->
                                <input type="hidden" name="MAX_FILE_SIZE" value="209715200" />
                                @if (Route::is('consulta.index'))
                                    
                                    <x-subir-archivo  :id="$fila->paciente->id"/>
                                @else
                                    <x-subir-archivo  :id="$consulta->paciente->id"/>
                                @endif
                                
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