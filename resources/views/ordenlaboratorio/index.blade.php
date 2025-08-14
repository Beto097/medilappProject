@extends('plantilla.plantillaDT')

@section('titulo')
    Órdenes de Laboratorio
@endsection

@section('css')    
    @include('scripts.validaciones')
    <style>
        .btn-mi-color {
            background-color: #499fad !important;
            color: #fff !important;
            border: none;
        }
        .btn-mi-color:hover, .btn-mi-color:focus {
            background-color: #357a8a !important;
            color: #fff !important;
        }
        
        /* Estilos para los labels de estado */
        .label {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 3px;
        }
        
        /* Botones de acción más pequeños */
        .btnIcono {
            padding: 4px 8px;
            font-size: 12px;
            margin: 1px;
        }
        
        /* Mejoras en la tabla */
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Inicializar la tabla primero
            var table = $('#datable_1').DataTable();
            
            // Configurar búsqueda después de que la tabla esté lista
            $('#datable_1').on('init.dt', function () {
                // Búsqueda dinámica en tiempo real
                $('#customSearch').off('keyup').on('keyup', function() {
                    table.search(this.value).draw();
                });
                
                // Búsqueda al hacer clic en el botón
                $('#customSearchBtn').off('click').on('click', function() {
                    var searchValue = $('#customSearch').val();
                    table.search(searchValue).draw();
                });
                
                // Búsqueda al presionar Enter
                $('#customSearch').off('keypress').on('keypress', function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        table.search(this.value).draw();
                    }
                });
            });
            
            // También configurar los eventos inmediatamente como respaldo
            setTimeout(function() {
                $('#customSearch').off('keyup').on('keyup', function() {
                    table.search(this.value).draw();
                });
                
                $('#customSearchBtn').off('click').on('click', function() {
                    var searchValue = $('#customSearch').val();
                    table.search(searchValue).draw();
                });
                
                $('#customSearch').off('keypress').on('keypress', function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        table.search(this.value).draw();
                    }
                });
            }, 1000);
        });
    </script>
@endsection

@section('contenido')
                    
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todas las órdenes de laboratorio registradas en el sistema.</p>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('ordenlaboratorio.create') }}" class="btn btn-primary btn-lable-wrap left-label btn-mi-color">
                <span class="btn-label"><i class="fa fa-plus"></i> </span>
                <span class="btn-text">Crear Orden</span>
            </a>
        </div>
        <br>
        <br>
        <br>
 
        <div class="col-sm-4 col-sm-offset-8">
          @include('plantilla.errores')
        </div>
        
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Lista de Órdenes de Laboratorio</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Paciente</th>
                                            <th>Cédula</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Exámenes</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Paciente</th>
                                            <th>Cédula</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Exámenes</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr>
                                                <td><strong>{{$fila->id}}</strong></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge badge-circle badge-primary mr-2">
                                                            {{ strtoupper(substr($fila->paciente->nombre_paciente, 0, 1) . substr($fila->paciente->apellido_paciente, 0, 1)) }}
                                                        </span>
                                                        <div>
                                                            <strong>{{$fila->paciente->nombre_paciente}} {{$fila->paciente->apellido_paciente}}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <code>{{$fila->paciente->identificacion_paciente}}</code>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($fila->fecha_orden)->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($fila->estado_orden_laboratorio == "Pendiente")
                                                        <span class="label label-warning">
                                                            <i class="fa fa-clock-o"></i> Pendiente
                                                        </span>
                                                    @elseif($fila->estado_orden_laboratorio == "En Proceso")
                                                        <span class="label label-info">
                                                            <i class="fa fa-spinner"></i> En Proceso
                                                        </span>
                                                    @elseif($fila->estado_orden_laboratorio == "Terminado")
                                                        <span class="label label-success">
                                                            <i class="fa fa-check"></i> Terminado
                                                        </span>
                                                    @elseif($fila->estado_orden_laboratorio == "Eliminado")
                                                        <span class="label label-danger">
                                                            <i class="fa fa-times"></i> Eliminado
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-info">
                                                        {{ $fila->examenes->count() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($fila->estado_orden_laboratorio == "Pendiente")
                                                        <a class="btn btn-info btn-sm btnIcono" 
                                                           title="Modificar orden" 
                                                           href="{{ route('ordenlaboratorio.update', ['id' => $fila->id]) }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm btnIcono" 
                                                           title="Eliminar orden" 
                                                           href="{{ route('ordenlaboratorio.delete', ['id' => $fila->id]) }}" 
                                                           onclick="return confirm('¿Está seguro de eliminar esta orden del sistema?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "Eliminado")
                                                        <a class="btn btn-warning btn-sm btnIcono" 
                                                           title="Restablecer orden" 
                                                           href="{{ route('ordenlaboratorio.desbloquear', ['id' => $fila->id]) }}" 
                                                           onclick="return confirm('¿Está seguro de restablecer esta orden al sistema?')">
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "En Proceso" || $fila->estado_orden_laboratorio == "Terminado")
                                                        <a class="btn btn-primary btn-sm btnIcono" 
                                                           title="Ver detalles de la orden" 
                                                           href="{{route('ordenLaboratorio.examenes',['id' => $fila->id])}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "Terminado")
                                                        <a class="btn btn-success btn-sm btnIcono" 
                                                           title="Imprimir orden" 
                                                           href="#" 
                                                           onclick="window.print()">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
