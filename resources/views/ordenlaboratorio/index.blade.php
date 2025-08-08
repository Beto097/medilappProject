@extends('plantilla.plantillaDT')

@section('titulo')
    Ordenes de Laboratorio
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
        
        /* Estilos para la búsqueda personalizada */
        .search-wrapper {
            margin-bottom: 20px;
        }
        
        .search-wrapper .input-group {
            max-width: 400px;
        }
        
        /* Estilos para los labels de estado */
        .label {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 3px;
        }
        
        /* Botones circulares más pequeños */
        .btn-circle {
            width: 32px;
            height: 32px;
            padding: 6px 0px;
            border-radius: 50%;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857143;
            margin: 1px;
        }
        
        /* Responsive table */
        @media (max-width: 768px) {
            .table-responsive {
                border: none;
            }
            
            .btn-circle {
                width: 28px;
                height: 28px;
                padding: 4px 0px;
                font-size: 11px;
            }
        }
        
        /* Mejorar la apariencia del panel */
        .panel-heading {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-bottom: 2px solid #499fad;
        }
        
        .panel-title {
            font-weight: 600;
            color: #2c3e50;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table;
            
            // Verificar si DataTable ya está inicializada
            if ($.fn.DataTable.isDataTable('#datable_1')) {
                // Si ya está inicializada, obtener la instancia existente
                table = $('#datable_1').DataTable();
                
                // Destruir la tabla existente para reconfigurarla
                table.destroy();
            }
            
            // Inicializar DataTable con configuración personalizada
            table = $('#datable_1').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                "order": [[0, "desc"]], // Ordenar por ID descendente
                "columnDefs": [
                    {
                        "targets": [6], // Columna de opciones
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "dom": 'lBfrtip',
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Excluir columna de opciones
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Excluir columna de opciones
                        }
                    }
                ],
                "responsive": true,
                "processing": true,
                "autoWidth": false
            });
            
            // Ocultar la búsqueda por defecto de DataTables
            $('.dataTables_filter').hide();
            
            // Configurar búsqueda personalizada
            function setupCustomSearch() {
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
                
                // Limpiar búsqueda
                $('#clearSearch').off('click').on('click', function() {
                    $('#customSearch').val('');
                    table.search('').draw();
                });
            }
            
            // Configurar búsqueda después de que la tabla esté lista
            table.on('init.dt', function () {
                setupCustomSearch();
            });
            
            // Configurar búsqueda inmediatamente si la tabla ya está lista
            setupCustomSearch();
            
            // Inicializar tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Reconfigurar tooltips después de cada redibujado de la tabla
            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });
    </script>
@endsection

@section('contenido')
    <br>
    <br>
    
    <!--muestro el error-->
    <div class="col-sm-4 col-sm-offset-8">
        @include('plantilla.errores')
    </div>
    <!-- fin del error-->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Ordenes de Laboratorio</h6>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('ordenlaboratorio.create') }}" class="btn btn-primary btn-rounded btn-mi-color">
                            <i class="fa fa-plus"></i> Crear Nueva Orden
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    <p class="mb-20 text-muted">
                        <i class="fa fa-info-circle"></i> 
                        Este listado muestra todas las Ordenes de Laboratorio que se encuentran en la institución.
                    </p>
                    
                    <!-- Búsqueda personalizada mejorada -->
                    <div class="row search-wrapper">
                        <div class="col-md-6 col-sm-8">
                            <div class="input-group">
                                <input type="text" id="customSearch" class="form-control" placeholder="Buscar por ID, cédula, paciente, médico...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="customSearchBtn" data-toggle="tooltip" title="Buscar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button class="btn btn-warning" type="button" id="clearSearch" data-toggle="tooltip" title="Limpiar búsqueda">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-4 text-right">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Actualizar tabla" onclick="location.reload()">
                                    <i class="fa fa-refresh"></i> Actualizar
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-wrap mt-40">
                        <div class="table-responsive">
                            <table id="datable_1" class="table table-hover display pb-30">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha Orden</th>
                                        <th>Cédula</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha Orden</th>
                                        <th>Cédula</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Médico</th>
                                        <th>Opciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($resultado as $fila)
                                        <tr>
                                            <td><strong>{{$fila->id}}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($fila->fecha_orden)->format('d/m/Y') }}</td>
                                            <td><code>{{$fila->paciente->identificacion_paciente}}</code></td>
                                            <td>
                                                <strong>{{$fila->paciente->nombre_paciente}} {{$fila->paciente->apellido_paciente}}</strong>
                                            </td>
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
                                                <span data-toggle="tooltip" title="Dr. {{$fila->medico->nombre_medico}}">
                                                    {{$fila->medico->nombre_medico}}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @if($fila->estado_orden_laboratorio == "Pendiente")
                                                        <a class="btn btn-success btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Modificar orden" 
                                                           href="{{ route('ordenlaboratorio.update', ['id' => $fila->id]) }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Eliminar orden" 
                                                           href="{{ route('ordenlaboratorio.delete', ['id' => $fila->id]) }}" 
                                                           onclick="return confirm('¿Está seguro de eliminar esta orden del sistema?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "Eliminado")
                                                        <a class="btn btn-warning btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Restablecer orden" 
                                                           href="{{ route('ordenlaboratorio.desbloquear', ['id' => $fila->id]) }}" 
                                                           onclick="return confirm('¿Está seguro de restablecer esta orden al sistema?')">
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "En Proceso" || $fila->estado_orden_laboratorio == "Terminado")
                                                        <a class="btn btn-info btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Ver detalles de la orden" 
                                                           href="{{route('ordenLaboratorio.examenes',['id' => $fila->id])}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($fila->estado_orden_laboratorio == "Terminado")
                                                        <a class="btn btn-primary btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Imprimir orden" 
                                                           href="#" 
                                                           onclick="window.print()">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @endif
                                                </div>
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
@endsection
