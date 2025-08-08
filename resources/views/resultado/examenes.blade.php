@extends('plantilla.plantilla')

@section('titulo')
   Exámenes de Laboratorio
@endsection

@section('css')
    <style>
        .order-info-card {
            border-left: 4px solid #4e73df;
        }
        .exam-card {
            transition: all 0.3s ease;
        }
        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .badge-status {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
    </style>
@endsection

@section('logopantalla')
    <i class="fas fa-vials"></i>
@endsection

@section('titulopantalla')
    Exámenes de Laboratorio
@endsection



@section('contenido')
    <div class="container-fluid">
        <!-- Mensajes de error y éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif      

      
        
        <div class="d-flex">
            <div class="mr-auto p-2 "><p class="mb-4">Este listado muestra los examenes que pertenecen a la orden de laboratorio</a></p></div>
            
        </div>
        
        <div class="row">
            <div class="col-md-12 text-center"><h4>Orden de Laboratorio Nº: {{$orden->id}}</h4></div>
            <div class="col-md-4"><h5>Fecha: {{$orden->fecha_orden}}</h5></div>
            <div class="col-md-4 text-center"><h5>Paciente: {{$orden->paciente->nombre_paciente}} {{$orden->paciente->apellido_paciente}}</h5></div>
            <div class="col-md-4 text-right"><h5>Identificacion: {{$orden->paciente->identificacion_paciente}}</h5></div>
            <div class="col-md-6"><h5>Medico: {{$orden->medico->nombre_medico}}-{{$orden->medico->numero_registro}}</h5></div>
            <div class="col-md-6 text-right"><h5>Estado: {{$orden->estado_orden_laboratorio}}@if($orden->enviado == '1') <i class="fas fa-paper-plane"></i>@endif</h5></div>
        </div>
        <div class="d-flex">
            <div class="mr-auto p-2">
                
            </div>
            
                @if ($permisos['insert']==1)
                    
                    @if($orden->estado_orden_laboratorio == 'Terminado')                        
                       
                        @if($count == 0)
                            @foreach ($tipos_examen as $tipo)
                                <div class="p-2"><a title="Imprimir todos los examenes de..." href="{{ route('imprimir.XGrupo', ['id'=>$orden->id,'tipo' => $tipo->id]) }}" class="btn btn-dark btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-print"></i>
                                    </span>
                                    <span class="text">{{$tipo->nombre_tipo_examen}}</span>
                                </a></div>
                                <button type="button" class="btn btn-primary btn-sm btn-icon-split" id="newMail"                
                                    data-toggle="modal" data-target="#newMailGroupModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-paper-plane"></i>
                                    </span>
                                    <span class="text">
                                    Enviar por Correo -{{$tipo->nombre_tipo_examen}}
                                    </span>
                                </button>
                                @include('modals.MailGroupModals')
                            @endforeach              
                            
                        @else
                            
                            
                        @endif
                        
                        
                    @endif
                                         
                @endif 
        
            
        </div>  
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Examenes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center col-md-12" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Examen</th> 
                                <th>Estado</th>                                                                                         
                                <th>Acciones</th>   
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Examen</th>
                                <th>Estado</th>                                                                                         
                                <th>Acciones</th>   
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($resultado as $fila)
                                @if ($fila->padre<=0)                             
                                
                                    <tr>
                                        <td scope="row ">{{ $fila->id}}</td>
                                        <td>
                                            @if (isset($fila->examen))
                                                {{$fila->examen->nombre_examen}}
                                            @else
                                                Sin Examen
                                            @endif
                                            
                                        </td>
                                        <td>{{$fila->estado_examen}}</td>
                                        <td>
                                            
                                            @if($fila->estado_examen=='Pendiente')                                            
                                                @if ($permisos['insert']==1)
                                                    @if ($fila->examen->es_externo==1)
                                                        <div class="row  justify-content-center">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-info btn-sm btn-block" id="resultadoSubirArchivo"                
                                                                    data-toggle="modal" data-target="#resultadoSubirArchivoModals">
                                                                    
                                                                    <span class="text">
                                                                        Subir Resultado                                                                        
                                                                    </span>
                                                                </button>                                                                
                                                            </div>                                                                
                                                        </div>
                                                        @include('modals.subirArchivoModals')
                                                    @else  
                                                            
                                                        @if (isset($fila->examen))                                                            
                                                            @if ($fila->padre==-1)
                                                                <div class="row  justify-content-center">
                                                                    <div class="col-6"> 
                                                                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('ordenLaboratorio.resultados1', ['id' => $fila->id]) }}" role="button">Registrar Resultados</a>
                                                                    </div>                                                                
                                                                </div>
                                                            @else
                                                                <div class="row  justify-content-center">
                                                                    <div class="col-6"> 
                                                                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('ordenLaboratorio.resultados', ['id' => $fila->id]) }}" role="button">Registrar Resultados</a>
                                                                    </div>                                                                
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="row  justify-content-center">
                                                                <div class="col-6"> 
                                                                    <a class="btn btn-danger btn-sm btn-block" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button">Eliminar Fila</a>
                                                                </div>                                                                
                                                            </div>
                                                        @endif                                                                 
                                                    @endif
                                                @endif
                                            
                                            @else                                                     

                                                @if ($permisos['ver']==1)
                                                     
                                                    @if ($fila->examen->es_externo==1)
                                                        
                                                            @foreach ($fila->resultado as $resultado)
                                                                                                                               
                                                                <a class="btn btn-success btn-sm" href="/public/pdf/{{$resultado->valor}}" role="button" target="_blank"><i id="iconoBoton" class="fas fa-eye"></i></a>
                                                                <button type="button" class="btn btn-primary btn-sm " id="enviarCorreo"                
                                                                data-toggle="modal" data-target="#newMailModal{{$fila->id}}">
                                                                <i class="fas fa-paper-plane"></i>
                                                                
                                                                </button>                                                                
                                                                
                                                                @include('modals.MailModals')
                                                                
                                                            @endforeach
                                                                                                                          
                                                        
                                                    @else    
                                                        @if (isset($fila->examen))                                                                                                                        
                                                        
                                                            <a class="btn btn-success btn-sm" title="Ver resultados" href="{{ route('ordenLaboratorio.ver.resultados', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="fas fa-eye"></i></a>
                                                            <a class="btn btn-dark btn-sm" title="Imprimir resultado" href="{{ route('imprimir.resultado', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="fas fa-print"></i></a>
                                                           
                                                            <button type="button" class="btn btn-primary btn-sm " id="enviarCorreo"                
                                                            data-toggle="modal" data-target="#newMailModal{{$fila->id}}">
                                                            <i class="fas fa-paper-plane"></i>
                                                            
                                                            </button>                                                                
                                                            
                                                            @include('modals.MailModals')                                                       
                                                                
                                                            
                                                            {{-- @if ($fila->orden_laboratorio->enviado == '0' && Session::get('usuario_rol_id')!=\App\Models\rol::select('id')->where('nombre_rol','Paciente')->first()->id)
                                                                <a class="btn btn-primary" title="Enviar al correo" href="{{ route('enviar.correo', ['id' => $fila->id]) }}" class=""><i id="iconoBoton" class="far fa-paper-plane"></i></a>
                                                            @endif --}}
                                                        
                                                        @else
                                                            <a class="btn btn-danger btn-sm" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button">Eliminar Fila</a>
                                                        @endif
                                                    @endif
                                                        
                                                @endif
                                                
                                                @if($permisos['update']==1)
                                                    @if ($fila->examen->es_externo!=1)
                                                            @if (isset($fila->examen))
                                                            <a class="btn btn-info btn-sm" title="Modificar resultados" href="{{ route('ordenLaboratorio.update.resultados', ['id' => $fila->id]) }}" ><i id="iconoBoton" class="fas fa-edit"></i></a>
                                                                                                                        
                                                        @endif
                                                    @endif  
                                                        
                                                @endif
                                                
                                            @endif   

                                            
                                                                            
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer')
    @include('plantillas.footer')
@section('contenidofooter')

@show
@endsection
@endsection

@section('footer')
    @include('plantilla.footer')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Configuración de DataTables
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "pageLength": 15,
            "lengthMenu": [15, 30, 50, 100],
            "responsive": true,
            "columnDefs": [
                {
                    "targets": [-1], // Última columna (acciones)
                    "orderable": false,
                    "searchable": false
                }
            ]
        });

        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection