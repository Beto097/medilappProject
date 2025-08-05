<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>@yield('titulo')</title>
	@yield('css')
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('favicon.ico')}}">
	<link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

	<!-- Data table CSS -->
	<link href="{{asset('vendors/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
	
	<!-- Custom CSS -->
	<link href="{{asset('dist/css/style.css')}}" rel="stylesheet" type="text/css">
	
</head>
<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->
    <div class="wrapper theme-4-active pimary-color-blue">
		<!-- Top Menu Items -->
		@include('plantilla.navbar')
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		@include('plantilla.sidebarleft')
		<!-- /Left Sidebar Menu -->
		
		

        <!-- Main Content -->
		<div class="page-wrapper">
            <!--añadir dashboard-->
			@include('modals.actualizarSucursalModals')
			@include('modals.actualizarPasswordModals')
			@yield('contenido')
			<!-- Footer -->
			@include('plantilla.footer')
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
    <!-- jQuery -->
    <script src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    
	<!-- Data table JavaScript -->
	<script src="{{asset('vendors/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('dist/js/dataTables-data.js')}}"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="{{asset('dist/js/jquery.slimscroll.js')}}"></script>
	
	<!-- Owl JavaScript -->
	<script src="{{asset('vendors/bower_components/owl.carousel/dist/owl.carousel.min.js')}}"></script>
	
	<!-- Switchery JavaScript -->
	<script src="{{asset('vendors/bower_components/switchery/dist/switchery.min.js')}}"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="{{asset('dist/js/dropdown-bootstrap-extended.js')}}"></script>
	
	<!-- Init JavaScript -->
	<script src="{{asset('dist/js/init.js')}}"></script>
	<script>
		var table = $('#datable_1').DataTable({
			 searching: false,
			"language": {
				
				"processing": "Procesando...",
				"lengthMenu": "Mostrar _MENU_ Registros",
				"zeroRecords": "No se encontraron resultados",
				"emptyTable": "Ningún dato disponible en esta tabla",
				"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
				"infoFiltered": "(filtrado de un total de _MAX_ registros)",
				"search": "Buscar:",
				"infoThousands": ",",
				"loadingRecords": "Cargando...",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": ">>",
					"previous": "<<"
				},
				"aria": {
					"sortAscending": ": Activar para ordenar la columna de manera ascendente",
					"sortDescending": ": Activar para ordenar la columna de manera descendente"
				},
				"buttons": {
					"copy": "Copiar",
					"colvis": "Visibilidad",
					"collection": "Colección",
					"colvisRestore": "Restaurar visibilidad",
					"copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
					"copySuccess": {
						"1": "Copiada 1 fila al portapapeles",
						"_": "Copiadas %d fila al portapapeles"
					},
					"copyTitle": "Copiar al portapapeles",
					"csv": "CSV",
					"excel": "Excel",
					"pageLength": {
						"-1": "Mostrar todas las filas",
						"1": "Mostrar 1 fila",
						"_": "Mostrar %d filas"
					},
					"pdf": "PDF",
					"print": "Imprimir"
				},
				"autoFill": {
					"cancel": "Cancelar",
					"fill": "Rellene todas las celdas con <i>%d<\/i>",
					"fillHorizontal": "Rellenar celdas horizontalmente",
					"fillVertical": "Rellenar celdas verticalmentemente"
				},
				"decimal": ",",
				"searchBuilder": {
					"add": "Añadir condición",
					"button": {
						"0": "Constructor de búsqueda",
						"_": "Constructor de búsqueda (%d)"
					},
					"clearAll": "Borrar todo",
					"condition": "Condición",
					"conditions": {
						"date": {
							"after": "Despues",
							"before": "Antes",
							"between": "Entre",
							"empty": "Vacío",
							"equals": "Igual a",
							"not": "No",
							"notBetween": "No entre",
							"notEmpty": "No Vacio"
						},
						"moment": {
							"after": "Despues",
							"before": "Antes",
							"between": "Entre",
							"empty": "Vacío",
							"equals": "Igual a",
							"not": "No",
							"notBetween": "No entre",
							"notEmpty": "No vacio"
						},
						"number": {
							"between": "Entre",
							"empty": "Vacio",
							"equals": "Igual a",
							"gt": "Mayor a",
							"gte": "Mayor o igual a",
							"lt": "Menor que",
							"lte": "Menor o igual que",
							"not": "No",
							"notBetween": "No entre",
							"notEmpty": "No vacío"
						},
						"string": {
							"contains": "Contiene",
							"empty": "Vacío",
							"endsWith": "Termina en",
							"equals": "Igual a",
							"not": "No",
							"notEmpty": "No Vacio",
							"startsWith": "Empieza con"
						}
					},
					"data": "Data",
					"deleteTitle": "Eliminar regla de filtrado",
					"leftTitle": "Criterios anulados",
					"logicAnd": "Y",
					"logicOr": "O",
					"rightTitle": "Criterios de sangría",
					"title": {
						"0": "Constructor de búsqueda",
						"_": "Constructor de búsqueda (%d)"
					},
					"value": "Valor"
				},
				"searchPanes": {
					"clearMessage": "Borrar todo",
					"collapse": {
						"0": "Paneles de búsqueda",
						"_": "Paneles de búsqueda (%d)"
					},
					"count": "{total}",
					"countFiltered": "{shown} ({total})",
					"emptyPanes": "Sin paneles de búsqueda",
					"loadMessage": "Cargando paneles de búsqueda",
					"title": "Filtros Activos - %d"
				},
				"select": {
					"1": "%d fila seleccionada",
					"_": "%d filas seleccionadas",
					"cells": {
						"1": "1 celda seleccionada",
						"_": "$d celdas seleccionadas"
					},
					"columns": {
						"1": "1 columna seleccionada",
						"_": "%d columnas seleccionadas"
					}
				},
				"thousands": "."
			
			}
			@yield('ordenarTabla')
		} );
				// Botón personalizado de búsqueda
		$('#customSearchBtn').on('click', function() {
			var value = $('#customSearch').val();
			$.ajax({
				url: '/paciente/ajax-buscar',
				method: 'GET',
				data: { q: value },
				success: function(response) {
					table.clear();
					response.data.forEach(function(row) {
						table.row.add(row);
					});
					table.draw();
				}
			});
		});

		// Permitir buscar con Enter
		$('#customSearch').on('keyup', function(e) {
			if (e.key === 'Enter') {
				$('#customSearchBtn').click();
			}
		});
		// Búsqueda automática al escribir (mínimo 2 letras)
		let lastValue = '';
		$('#customSearch').on('input', function() {
			var value = $(this).val();
			if (value.length >= 2 && value !== lastValue) {
				lastValue = value;
				$.ajax({
					url: '/paciente/ajax-buscar',
					method: 'GET',
					data: { q: value },
					success: function(response) {
						table.clear();
						response.data.forEach(function(row) {
							table.row.add(row);
						});
						table.draw();
					}
				});
			}
			if (value.length < 2) {
				lastValue = '';
				// Opcional: puedes recargar los 100 primeros pacientes aquí si quieres
			}
		});
	</script>
	@yield('script')
</body>

</html>
