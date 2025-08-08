@extends('plantilla.plantilla')

@section('titulo')
   Resultados de Laboratorio
@endsection

@section('css')
    <style>
        /* Estilos para los labels de estado */
        .badge-estado {
            padding: 0.5rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
        }
        .badge-pendiente { background-color: #ffc107; color: #000; }
        .badge-proceso { background-color: #17a2b8; color: #fff; }
        .badge-terminado { background-color: #28a745; color: #fff; }
        .badge-eliminado { background-color: #dc3545; color: #fff; }
        
        .btn-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }

        .table td {
            vertical-align: middle;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
@endsection

@section('logopantalla')
    <i class="fas fa-flask"></i>
@endsection

@section('titulopantalla')
    Resultados de Laboratorio
@endsection



@section('contenido')
    <div class="container-fluid">
        <!-- Mensajes -->
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

        <!-- Información -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="h4 mb-0 text-gray-800">
                            <i class="fas fa-flask text-primary mr-2"></i>
                            Órdenes de Laboratorio
                        </h4>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Gestión de resultados de órdenes de laboratorio
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('resultado.historial') }}" class="btn btn-primary">
                            <i class="fas fa-history mr-1"></i>
                            Ver Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla de Órdenes -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i>
                    Lista de Órdenes de Laboratorio
                </h6>
            </div>
            <div class="card-body">
                @if(isset($resultado) && $resultado->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Paciente</th>
                                    <th class="text-center">Cédula</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Exámenes</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultado as $fila)
                                    <tr>
                                        <td class="text-center font-weight-bold">{{ $fila->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle mr-3">
                                                    {{ strtoupper(substr($fila->paciente->nombre_paciente ?? 'N', 0, 1)) }}{{ strtoupper(substr($fila->paciente->apellido_paciente ?? 'A', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $fila->paciente->nombre_paciente ?? 'N/A' }} {{ $fila->paciente->apellido_paciente ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary">{{ $fila->paciente->identificacion_paciente ?? 'N/A' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <i class="fas fa-calendar-alt text-primary mr-1"></i>
                                            {{ $fila->fecha_orden ? \Carbon\Carbon::parse($fila->fecha_orden)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            @if($fila->estado_orden_laboratorio == "Pendiente")
                                                <span class="badge badge-estado badge-pendiente">
                                                    <i class="fas fa-clock mr-1"></i> Pendiente
                                                </span>
                                            @elseif($fila->estado_orden_laboratorio == "En Proceso")
                                                <span class="badge badge-estado badge-proceso">
                                                    <i class="fas fa-spinner mr-1"></i> En Proceso
                                                </span>
                                            @elseif($fila->estado_orden_laboratorio == "Terminado")
                                                <span class="badge badge-estado badge-terminado">
                                                    <i class="fas fa-check mr-1"></i> Terminado
                                                </span>
                                            @else
                                                <span class="badge badge-estado badge-eliminado">
                                                    <i class="fas fa-times mr-1"></i> {{ $fila->estado_orden_laboratorio }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (isset($numero_examenes[$fila->id]))
                                                <span class="badge badge-info badge-pill">
                                                    <i class="fas fa-vial mr-1"></i>
                                                    {{ $numero_examenes[$fila->id] }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary badge-pill">
                                                    <i class="fas fa-minus mr-1"></i>
                                                    0
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if ($fila->estado_orden_laboratorio == 'Pendiente')
                                                    <a class="btn btn-warning btn-circle" 
                                                       data-toggle="tooltip" 
                                                       title="Ver detalles - Pendiente" 
                                                       href="{{ route('ordenLaboratorio.examenes', ['id' => $fila->id]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @elseif($fila->estado_orden_laboratorio == 'En Proceso')
                                                    <a class="btn btn-info btn-circle" 
                                                       data-toggle="tooltip" 
                                                       title="Ver detalles - En Proceso" 
                                                       href="{{ route('ordenLaboratorio.examenes', ['id' => $fila->id]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @elseif($fila->estado_orden_laboratorio == 'Terminado')
                                                    <a class="btn btn-success btn-circle" 
                                                       data-toggle="tooltip" 
                                                       title="Ver resultados - Terminado" 
                                                       href="{{ route('ordenLaboratorio.examenes', ['id' => $fila->id]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->accesoRuta('/resultado/update'))
                                                    @if($fila->estado_orden_laboratorio == 'En Proceso' || $fila->estado_orden_laboratorio == 'Terminado')
                                                        <a class="btn btn-primary btn-circle" 
                                                           data-toggle="tooltip" 
                                                           title="Editar resultados" 
                                                           href="{{ route('ordenLaboratorio.examenes', ['id' => $fila->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-flask fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">No hay órdenes de laboratorio</h5>
                        <p class="text-muted">No se encontraron órdenes de laboratorio en el sistema.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('plantilla.footer')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Verificar si la tabla existe antes de inicializar DataTables
        if ($("#dataTable").length) {
            // Configuración de DataTables
            $('#dataTable').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "order": [[ 0, "desc" ]], // Ordenar por ID descendente
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "responsive": true,
                "columnDefs": [
                    { "orderable": false, "targets": [6] }, // Desactivar ordenamiento en la columna de acciones
                    { "className": "text-center", "targets": [0, 2, 3, 4, 5, 6] } // Centrar columnas específicas
                ],
                "drawCallback": function() {
                    // Inicializar tooltips después de cada redibujado
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }

        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Efecto hover en las filas
        $('#dataTable tbody').on('mouseenter', 'tr', function() {
            $(this).addClass('table-active');
        }).on('mouseleave', 'tr', function() {
            $(this).removeClass('table-active');
        });

        // Mostrar estadísticas básicas en la consola
        var totalOrdenes = $('#dataTable tbody tr').length;
        if (totalOrdenes > 0) {
            console.log('Total de órdenes cargadas: ' + totalOrdenes);
        } else {
            console.log('No hay órdenes disponibles en la tabla');
        }
    });
</script>
@endsection
