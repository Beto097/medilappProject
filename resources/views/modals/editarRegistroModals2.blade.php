<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="editarRegistro2Modal{{$fila->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Consulta</h5>
            </div>
            <div class="modal-body">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route('consulta.save')}}" method="POST" role="form" class="form-horizontal" >
                                @csrf                             
                            
                                
                                <div class="row">
                                    @isset($fila->responsable_menor)                                        
                                    
                                        <div class="col-md-6 col-sm-6 col-xs-6">                                    
                                            <label class="control-label text-left">Nombre del Responsable</label>
                                            <input type="text" class="form-control" id="txtFrecR" placeholder="14-18" name="txtFrecR"
                                                value="{{$fila->responsable_menor}}"  >
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">                                    
                                            <label class="control-label text-left">Parentesco</label>
                                            <input type="text" class="form-control" id="txtFrecR" placeholder="14-18" name="txtFrecR"
                                                value="{{$fila->parentesco_menor}}"  >
                                        </div>  
                                    @endif
                                    
                                    
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label class="control-label text-left">Fecha</label>
                                        <input type="date" class="form-control" id="txtFecha" name="txtFecha" 
                                            value="{{$fila->fecha_consulta}}" required>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Frecuencia Respiratoria</label>
                                        <input type="text" class="form-control" id="txtFrecR" placeholder="14-18" name="txtFrecR"
                                            value="{{$fila->frecuencia_respiratoria}}"  >
                                    </div>  
                                    <div class="col-md-4 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Frecuencia Cardiaca</label>
                                        <input type="text" class="form-control" id="txtFrecC" placeholder="60-100" name="txtFrecC"
                                            value="{{$fila->frecuencia_cardiaca}}" >
                                    </div>  
                                    <div class="col-md-4 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Presion Arterial</label>
                                        <input type="text" class="form-control" id="txtPresA" placeholder="120/80" name="txtPresA"
                                            value="{{$fila->presion_arterial}}" >
                                    </div> 
                                    <div class="col-md-4 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Temperatura</label>
                                        <input type="text" class="form-control" id="txtTemp" placeholder="36-37" name="txtTemp"
                                            value="{{$fila->temperatura}}" >
                                    </div>    
                                    <div class="col-md-4 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Saturacion de Oxigeno</label>
                                        <input type="text" class="form-control" id="txtSatO" placeholder="95-100" name="txtSatO"
                                            value="{{$fila->saturacion_oxigeno}}" >
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-danger text-left">Alergias</label>
                                        <textarea class="form-control is-invalid" id="exampleFormControlTextarea1" style="border-color: red"
                                                placeholder="" name="txtAlergias" rows="3" autocomplete="off">{{$fila->alergias}}</textarea>                                        
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-danger text-left">Atecedente Personales(APP)</label>
                                        <textarea class="form-control is-invalid" id="exampleFormControlTextarea1" style="border-color: red"
                                                placeholder="" name="txtMedicamentos" rows="3" autocomplete="off">{{$fila->medicinas}}</textarea>                                        
                                    </div> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-left">Historia Clinica</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                                placeholder="" name="txtHistoriaClinica" rows="3" autocomplete="off">{{$fila->historia_clinica}}</textarea>                                        
                                    </div> 
                                    <div class="col-md-8 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-left">Examen Fisico</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                                placeholder="" name="txtExamenFisico" rows="5" autocomplete="off">{{$fila->examen_fisico}}</textarea>                                        
                                    </div> 
                                    <div class="col-md-4 col-sm-12 col-xs-12">  
                                        <div class="row">
                                            <div class="col-md-12 col-sm-6 col-xs-6">                                    
                                                <label class="control-label text-left">Peso</label>
                                                <input type="text" class="form-control" id="txtPeso" placeholder="150" name="txtPeso"
                                                    value="{{$fila->peso}}" >
                                            </div>
                                            <div class="col-md-12 col-sm-6 col-xs-6">                                    
                                                <label class="control-label text-left">Talla</label>
                                                <input type="text" class="form-control" id="txtTalla" placeholder="1.80" name="txtTalla"
                                                    value="{{$fila->talla}}" >
                                            </div>

                                        </div>
                                    </div> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-left">Laboratorios/Examenes</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                                placeholder="" name="txtLaboratoriosExamenes" rows="3" autocomplete="off">{{$fila->laboratorios_examenes}}</textarea>                                        
                                    </div>   

                                    <div class="col-md-12 col-sm-6 col-xs-6">                                    
                                        <label class="control-label text-left">Diagnóstico</label>
                                        <input type="text" class="form-control" id="txtDiagnostico" placeholder="" name="txtDiagnostico"
                                            value="{{$fila->diagnostico}}" >
                                    </div>                                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">                                    
                                        <label class="control-label text-left">Tratamientos - Recomendaciones</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                                placeholder="" name="txtRecomendaciones" rows="3" autocomplete="off">{{$fila->recomendaciones}}</textarea>                                        
                                    </div> 
                                                                    
                                    
                                    
                                  
                                        
                                    <input type="hidden" name="txtConsultaId" id="txtConsultaId" class="form-control form-control-sm" value="{{$fila->id}}">
                                     
                                    
                                </div>                            
                                <div class="modal-footer"> 
                                    <button type="submit" name='accion' value='terminar' id="btnCrearModal"  class="btn btn-primary mb-10  text-left">Terminar</button> 

                                    <button type="submit" name='accion' value='guardar' id="btnCrearModal"  class="btn btn-primary mb-10  text-left">Guardar</button>
                                </div> 
                                    
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <script>
        // Función para obtener la fecha actual en formato YYYY-MM-DD
        function obtenerFechaActual() {
          const hoy = new Date();
          const año = hoy.getFullYear();
          const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Mes en formato 01-12
          const dia = String(hoy.getDate()).padStart(2, '0'); // Día en formato 01-31
          return `${año}-${mes}-${dia}`;
        }
      
        // Asignar la fecha actual al input
        if (!document.getElementById('txtFecha').value) {
            document.getElementById('txtFecha').value = obtenerFechaActual(); 
        }
        
      </script>
    <!-- /.modal-dialog -->
</div>