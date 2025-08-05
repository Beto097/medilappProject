@extends('plantilla.plantillaDT')
@section('titulo')
    Consulta
@endsection

@section('css')    

    @include('scripts.agregar')
    
@endsection

@section('contenido')

  <div class="row">
    <br>
    <br>
    <br>

    <div class="col-sm-4 col-sm-offset-8">
          @include('plantilla.errores')
        </div>
 
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="panel-title txt-dark">{{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}}</h6>   
                    </div>
                    
                      @isset($consulta)
                        <div class="col-sm-8 text-end d-flex flex-wrap justify-content-end align-items-center gap-2">
                          @if ($consulta->estado_consulta == 'EN CURSO' || ($consulta->estado_consulta == 'TERMINADO' && $consulta->created_at>\Carbon\Carbon::now()->subHours(24)))
                        <button title="Crear Receta" class="btn @if ($consulta->tieneReceta()) btn-success @else btn-primary @endif font-weight-bold" id="addNewReceta" data-toggle="modal" data-target="#addNewRecetaModal">
                          @if ($consulta->tieneReceta())
                              Editar Receta
                          @else
                              Crear Receta
                          @endif
                        </button>
                        @if ($consulta->tieneReceta())
                            @include('modals.editarRecetaModals')
                          @else
                              @include('modals.RecetaModals') 
                          @endif
                        @if (!$consulta->tieneReferencia())
                            <button class="btn btn-danger font-weight-bold" id="addNewReferencia" title="Crear Referencia" data-toggle="modal" data-target="#addNewReferenciaModal">
                                Referencia
                            </button>
                            @include('modals.ReferenciaModals')                            
                        @endif 

                        @if (!$consulta->tieneConstancia())
                            <button class="btn btn-warning font-weight-bold" id="addNewConstancia" title="Crear Constancia" data-toggle="modal" data-target="#addNewConstanciaModal">
                                Constancia
                            </button>
                            @include('modals.ConstanciaModals')
                        @endif   
                    @endif

                    <button class="btn btn-success font-weight-bold" id="addNewFile" title="Cargar Archivo" data-toggle="modal" data-target="#addNewFileModal">
                        Cargar Archivo
                    </button>
                    @include('modals.FileModals2')

                    @if (!$consulta->tieneCertificado())
                        <button class="btn btn-info font-weight-bold" id="addNewCertificado" title="Crear Certificado" data-toggle="modal" data-target="#addNewCertificadoModal">
                            Certificado B. Salud
                        </button>
                        @include('modals.CertificadoModals')                          
                    @endif

                    @if ($consulta->tieneImprimir())
                        <button class="btn btn-warning font-weight-bold" id="addImprimir" title="Imprimir Documentos" data-toggle="modal" data-target="#imprimirModal{{$consulta->id}}">
                            Papelería
                        </button>
                        @include('modals.ImprimirModals2')
                    @endif

                    @if ($consulta->estado_consulta != 'TERMINADA')
                        <button class="btn btn-primary font-weight-bold" id="addNewRegistro" title="Registrar Consulta" data-toggle="modal" data-target="#addNewRegistroModal">
                            Atender Consulta
                        </button>
                        @include('modals.RegistroModals')  
                    @endif
                        </div>
                      @endisset
                    
                  </div>
                    
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3">
                      <ul class="list-unstyled mb-0">
                        <li class="" style="font-size: 130%"><i class="zmdi zmdi-card me-2 text-success font-size-18"></i>
                          <b>
                        Cédula</b> : {{$paciente->identificacion_paciente}}</li>
                        <li class="" style="font-size: 130%"><i class="zmdi zmdi-account me-2 text-success font-size-18"></i> <b>
                          Nombre</b> : {{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}} </li>
                        <li class="" style="font-size: 130%"><i class="zmdi zmdi-male-female me-2 text-success font-size-18"></i> <b>
                                Sexo </b> : @if ($paciente->sexo_paciente=='m')
                                    Masculino
                                @else
                                    Femenino
                                @endif</li>
                        <li class="" style="font-size: 130%"><i
                                class="zmdi zmdi-cake text-success font-size-18 mt-2 me-2"></i>
                            <b> Edad </b> : {{$paciente->edad()}}
                        </li>
                        <li class="" style="font-size: 130%"><i class="zmdi zmdi-phone-end me-2 text-success font-size-18"></i> <b>
                          Telefono</b> : {{$paciente->telefono_paciente}}</li>
                        @if (\Carbon\Carbon::parse($paciente->fecha_nacimiento_paciente)->age>18)
                          <li class="" style="font-size: 130%"><i class="zmdi zmdi-male-female me-2 text-success font-size-18"></i> <b>
                              Estado Civil</b> : {{$paciente->estado_civil_paciente}}</li>
                          <li class="" style="font-size: 130%"><i
                                class="zmdi zmdi-city-alt text-success font-size-18 mt-2 me-2"></i>
                            <b>Lugar de Trabajo</b> : {{$paciente->lugar_trabajo}}
                          </li>
                        @endif
                        <li class="" style="font-size: 130%"><i
                                class="zmdi zmdi-google-maps text-success font-size-18 mt-2 me-2"></i>
                            <b>Direccion</b> : {{$paciente->direccion_paciente}}
                        </li>
                        @if (\Carbon\Carbon::parse($paciente->fecha_nacimiento_paciente)->age<18)
                                      <li class="" style="font-size: 130%"><i><
                                        class="zmdi zmdi-accounts-alt text-success font-size-18 mt-2 me-2"></i>
                                    <b>Responsable</b> : {{$consulta->responsable_menor}}
                                </li>
                                <li class="" style="font-size: 130%"><i
                                  class="zmdi zmdi-accounts-alt text-success font-size-18 mt-2 me-2"></i>
                              <b>Parentesco</b> : {{$consulta->parentesco_menor}}
                          </li>
                        @endif
                        
                      </ul>
                      <div class="row" style="margin-top: 30px;">
                        
                          <div class="col-md-6 col-md-offset-3">
                            <a class="btn btn-lg btn-primary text-center" target="_blank" title="Ver Archivo" href="{{route('paciente.verArchivo', ['id'=> $paciente->id] )}}" class="">Ver Archivos</a>

                          </div>
                       
                        
                      </div>  
                    </div>
                    <div class="col-md-9">
                      <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="datable_1" class="table table-hover display  pb-30" cellspacing="0"  style="width:100%">
                                <thead>
                                  <tr>
                                    <th>ID</th>                    
                                    <th>Fecha</th>      
                                    <th>Estado</th>              
                                    <th>Diagnóstico</th>
                                    <th>Medico</th> 
                                    <th>Acciones</th>
                                  </tr>
                                </thead>
                                
                                <tbody>
                                  @foreach ($paciente->consultas as $key=>$fila)
                                    @if ($fila->estado_consulta !='CANCELADA' && $fila->estado_consulta !='ELIMINADA')
                                    <tr style="font-size: 100%;">
                                      <td>{{$key+1}}</td>
                                      <td>{{\Carbon\Carbon::parse($fila->fecha_consulta)->format('Y-m-d h:m')}}</td>
                                      <td>{{$fila->estado_consulta}}</td>
                                      <td>{{$fila->diagnostico}}</td>   
                                      <td>{{$fila->doctor->nombre_usuario}}</td>                 
                                      <td>
                                                                             
                                        @if ($fila->tieneImprimir())
                                          <button class="btn btn-warning" title="Imprimir Documentos" data-toggle="modal" data-target="#imprimirModal{{$fila->id}}">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                          </button>
                                          @include('modals.ImprimirModals')
                                        @endif
                                        
                                        @if ($fila->created_at->addHours(24)>\Carbon\Carbon::now() && Auth::user()->accesoRuta('/consulta/registrar') )
                                          
                                          <button type="button" class="btn btn-success waves-effect waves-light"
                                              data-toggle="modal" data-animation="bounce" title="Editar Consulta"
                                              data-target="#editarRegistro2Modal{{$fila->id}}">
                                            
                                              <i class="fa fa-edit"></i>
                                          </button>
                                          @include('modals.editarRegistroModals2')
                                        @endif
                                        
                                        @if ($fila->created_at->addHours(24)<\Carbon\Carbon::now() && Auth::user()->accesoRuta('/paciente/historia/clinica'))
                                                                
                                          <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-toggle="modal" data-animation="bounce"
                                            data-target="#editarRegistroModal{{$fila->id}}">
                                          
                                            Ver Historia
                                          </button>
                                        @include('modals.editarRegistroModals')
                                            
                                        @endif
                                        {{--
                                        
                                        @if (Auth::user()->accesoRuta('/paciente/consulta'))                        
                                          <a class="btn btn-info btn-sm btnIcono" title="Atender Consulta" href="{{route('consulta.create', ['id'=> $fila->id] )}}" class=""><i id="iconoBoton" class="fas fa-file-medical"></i></a>
                                          
                                        @endif  
                  
                                        {{-- @if (Auth::user()->accesoRuta('/consulta/update'))
                                          <button type="button" class="btn btn-success btn-sm"
                                            data-bs-toggle="modal" data-animation="bounce"
                                            data-bs-target=".editarConsultaModal{{$fila->id}}">
                                            <i id="iconoBoton" class="fas fa-user-edit"></i>
                                          </button>  
                                          @include('modals.editarConsultaModals')
                                        @endif
                  
                                        @if (Auth::user()->accesoRuta('/consulta/delete'))
                                          @if($fila->estado_consulta == 1)
                  
                                            <a class="btn btn-danger btn-sm btnIcono" title="Eliminar consulta" href="{{route('consulta.delete', ['id'=> $fila->id] )}}" onclick="
                                              return confirm('Desea eliminar este consulta del sistema?')"><i id="iconoBoton" class="fas fa-user-times"></i></a>
                                          
                                          @else
                                            
                                            <a class="btn btn-warning btn-sm btnIcono" title="Desbloquear consulta" href="{{route('consulta.desbloquear', ['id'=> $fila->id] )}}" onclick="
                                              return confirm('Desea desbloquear este consulta del sistema?')"><i id="iconoBotonW" class="fas fa-user-shield"></i></a>
                                          
                                          @endif 
                                        
                                        @endif 
                                        --}}
                                      </td>
                                    </tr>
                                    @endif
                                  
                                  @endforeach
                                  
                                </tbody>
                            
                                <tfoot>
                                  <tr>
                                    <th>ID</th>                    
                                    <th>Fecha</th>      
                                    <th>Estado</th>              
                                    <th>Diagnóstico</th>
                                    <th>Medico</th> 
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
    </div>
  </div>

@endsection
@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('formCrearConstancia');

      form.addEventListener('submit', function (e) {
          e.preventDefault();

          const formData = new FormData(form);

          fetch(form.action, {
              method: 'POST',
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('[name=_token]').value
              },
              body: formData
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
          })
          .then(data => {
              if (data.success && data.pdf_url) {
                  $('#addNewConstanciaModal').modal('hide');
                  window.open(data.pdf_url, '_blank');
              } else {
                  alert('Error al generar constancia: ' + (data.error || 'Error desconocido'));
              }
          })
          .catch(error => {
              console.error('Error completo:', error);
              alert('Error inesperado: ' + (error.message || error));
          });
      });
  });
</script>

@endsection




