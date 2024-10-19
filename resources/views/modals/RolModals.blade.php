<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="addNewRolModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Rol</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('rol.insert')}}" method="POST" role="form" autocomplete="off">  
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Nombre</label>
                                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Recepcionista" name="txtNombre" required>
                                    </div> 
                                    @if (Auth::user()->rol_id=1)
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label for="">Seleccione una compañia</label>
                                                <select class="form-control" name="txtCompany" id="" value="" required>
                                                
                                                    @foreach($companys as $company)
                                                
                                                    
                                                        <option value="{{$company->id}}" >{{$company->company_name}}</option>
                                                    
                                                    
                                                    @endforeach
                                            
                                                </select>
                                            </div>
                                            @error('txtCompany')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                
                                    
                                </div>                                
                               
                             

                                <div class="modal-footer">                                        
                                    <button type="submit" id="btnCrearMedicoModal"  class="btn btn-primary text-left">Guardar</button>
                                </div>
                                
                
                            </form>
                        </div>
                    </div>
                </div>              

            </div>

        </div>

    </div>

</div>


