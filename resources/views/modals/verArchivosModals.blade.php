<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="verArchivosModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Ver Archivos</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table id="datable_2" class="table table-hover display  pb-30" cellspacing="0"  style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>Nombre</th>                
                                            <th>Fecha</th> 
                                            <th>Acciones</th>                                   
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                        
                                        @foreach ($paciente->archivos as $key=>$archivo)
                                            
                                          
                                            <tr style="font-size: 100%;">
                                                
                                              <td><a href="{{ asset($archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a></td>
                                              <td> {{\Carbon\Carbon::parse($archivo->created_at)->format('d/m/Y')}}</td>      
                                              <td>
                                                @if(Auth::user()->accesoRuta('/archivo/ver'))
                                                  <a class="btn btn-success btn-sm btnIcono" title="Ver Archivo" href="{{ asset($archivo->ruta) }}" target="_blank">
                                                    <i id="iconoBoton" class="fa fa-eye"></i>
                                                  </a>
                                                @endif
                                                @if(Auth::user()->accesoRuta('/archivo/delete'))
                                                  <a class="btn btn-danger btn-sm btnIcono" title="Eliminar Archivo" href="{{route('archivo.delete', ['id'=> $archivo->id] )}}" onclick="
                                                    return confirm('Desea eliminar este archivo del sistema?')"><i id="iconoBoton" class="fa fa-trash"></i>
                                                  </a>
                                                @endif
                                              </td>
                                            </tr>
                                            
                                          
                                          @endforeach
                                          
                                        </tbody>
                                    
                                        <tfoot>
                                          <tr>
                                            <th>Nombre</th>                
                                            <th>Fecha</th>
                                            <th>Acciones</th>  
                                          </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>