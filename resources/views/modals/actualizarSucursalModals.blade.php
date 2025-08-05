<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="actualizarSucursalModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar Sucursal</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            @if (Auth::user()->accesoRuta('/sucursal/actualizar'))  
                                <form action="{{route('sucursal.actualizar')}}" method="POST" role="form" autocomplete="off">
                                    @csrf
                                    <div class="form-group col-md-2 col-sm-12 col-xs-12"> 

                                    </div>
                                    <div class="form-group col-md-8 col-sm-12 col-xs-12">                                        
                                        
                                            
                                        <x-lista-sucursales2 />

                                    </div>
                                    <div class="modal-footer">                                        
                                        <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
                                    </div>
                                    
                    
                                </form>
                            @else
                                <h6 class="text-center text-danger">!!No tienes permisos para cambiar tu sucursal!!</h6>
                            @endif
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>
