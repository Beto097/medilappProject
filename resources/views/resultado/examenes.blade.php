@extends('plantilla.plantillaDT')

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

        <br>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <p class="mb-4">
                    Este listado muestra los examenes que pertenecen a la orden de laboratorio
                </p>
            </div>
        </div> 
        <br>
        <div class="row justify-content-center">
            <div class="col-md-11-center">
                <div class="panel panel-default card-view">
                <div class="panel-heading">
                        <div class="pull-left">
                            <h5 class="panel-title txt-dark">Orden de Laboratorio Nº: {{$orden->id}}</h5>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <div class="panel-body">
                    <div class="col-md-12 text-center">
                        <h4 class="txt-dark font-weight-bold">{{$orden->paciente->nombre_paciente}} {{$orden->paciente->apellido_paciente}}</h4>
                    </div><br><br>
                    <br>
                    <div class="col-md-6 text-center">
                        <h5 class="txt-dark">Fecha: {{$orden->fecha_orden}}</h5>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5 class="txt-dark">Identificacion: {{$orden->paciente->identificacion_paciente}}</h5>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5 class="txt-dark">Medico: {{$orden->medico->nombre_medico}}-{{$orden->medico->numero_registro}}</h5>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5 class="txt-dark">
                            Estado: {{$orden->estado_orden_laboratorio}}
                            @if($orden->enviado == '1')
                                <i class="fas fa-paper-plane"></i>
                            @endif
                        </h5>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="mr-auto p-2"></div>
                    @if (Auth::user()->accesoRuta('/resultado/crear'))
                        @if($orden->estado_orden_laboratorio == 'Terminado')
                            @if($count == 0)
                                @foreach ($tipos_examen as $tipo)
                                    <div class="p-2">
                                        <a title="Imprimir todos los examenes de..." href="{{ route('imprimir.XGrupo', ['id'=>$orden->id,'tipo' => $tipo->id]) }}" class="btn btn-dark btn-sm btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                            <span class="text">{{$tipo->nombre_tipo_examen}}</span>
                                        </a>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm btn-icon-split" id="newMail" data-toggle="modal" data-target="#newMailGroupModal">
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
                                {{-- Otro contenido si $count != 0 --}}
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
                            <table id="datable_1" class="table table-hover display pb-30" cellspacing="0" style="width:100%">
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
                                                <td scope="row">{{ $fila->id}}</td>
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
                                                        @if (Auth::user()->accesoRuta('/resultado/crear'))
                                                            @if ($fila->examen->es_externo==1)
                                                                <div class="text-center">
                                                                    <button type="button" class="btn btn-info btn-sm font-weight-bold" id="resultadoSubirArchivo" data-toggle="modal" data-target="#resultadoSubirArchivoModals" style="min-width: 100px;">
                                                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir
                                                                    </button>
                                                                </div>
                                                                @include('modals.subirArchivoModals')
                                                            @else  
                                                                @if (isset($fila->examen))                                                            
                                                                    @if ($fila->padre==-1)
                                                                        <div class="text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#RegistrarResultadoModal{{$fila->id}}" style="min-width: 100px;">
                                                                                <i class="fa fa-pencil" aria-hidden="true"></i> Registrar
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#RegistrarResultadoModal{{$fila->id}}" style="min-width: 100px;">
                                                                                <i class="fa fa-pencil" aria-hidden="true"></i> Registrar
                                                                            </button>
                                                                        </div>
                                                                        @include('modals.RegistrarResultadoModal')
                                                                    @endif
                                                                @else
                                                                    <div class="text-center">
                                                                        <a class="btn btn-danger btn-sm font-weight-bold" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button" style="min-width: 100px;">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                                                                        </a>
                                                                    </div>
                                                                @endif                                                                 
                                                            @endif
                                                        @endif
                                                    @else                                                     
                                                        @if (Auth::user()->accesoRuta('/resultado/ver'))
                                                            @if ($fila->examen->es_externo==1)
                                                                <div class="text-center">
                                                                    @foreach ($fila->resultado as $resultado)
                                                                        <a class="btn btn-success btn-sm mr-1 font-weight-bold" href="/public/pdf/{{$resultado->valor}}" role="button" target="_blank" title="Ver resultado">
                                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-primary btn-sm font-weight-bold" id="enviarCorreo" title="Enviar por correo" data-toggle="modal" data-target="#newMailModal{{$fila->id}}">
                                                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                        </button>                                                                
                                                                        @include('modals.MailModals')
                                                                    @endforeach
                                                                </div>
                                                            @else    
                                                                @if (isset($fila->examen))
                                                                    <div class="text-center">                                                                                                                      
                                                                        <a class="btn btn-success btn-sm mr-1 font-weight-bold" title="Ver resultados" href="{{ route('ordenLaboratorio.ver.resultados', ['id' => $fila->id]) }}">
                                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a class="btn btn-dark btn-sm mr-1 font-weight-bold" title="Imprimir resultado" href="{{ route('imprimir.resultado', ['id' => $fila->id]) }}">
                                                                            <i class="fa fa-print" aria-hidden="true"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-primary btn-sm font-weight-bold" id="enviarCorreo" title="Enviar por correo" data-toggle="modal" data-target="#newMailModal{{$fila->id}}">
                                                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                        </button>                                                                
                                                                        @include('modals.MailModals')
                                                                    </div>
                                                                @else
                                                                    <div class="text-center">
                                                                        <a class="btn btn-danger btn-sm font-weight-bold" href="{{ route('ordenLaboratorio.examen.eliminar', ['id' => $fila->id]) }}" role="button" title="Eliminar fila" style="min-width: 100px;">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @if(Auth::user()->accesoRuta('/resultado/crear'))
                                                            @if ($fila->examen->es_externo!=1)
                                                                @if (isset($fila->examen))
                                                                    <a class="btn btn-info btn-sm" title="Modificar resultados" href="{{ route('ordenLaboratorio.update.resultados', ['id' => $fila->id]) }}">
                                                                        <i id="iconoBoton" class="fas fa-edit"></i>
                                                                    </a>
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
                </div> <!-- Cierre del panel -->
            </div> <!-- Cierre del col-lg-10 -->
        </div> <!-- Cierre del row justify-content-center -->
    </div> <!-- Cierre del container-fluid -->
@endsection

@section('footer')
    @include('plantilla.footer')
@section('contenidofooter')
@show
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
