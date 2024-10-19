<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Medilapp - Inicio de sesión</title>
		
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Descubre nuestra innovadora aplicación de gestión de expedientes de laboratorios. Simplifica y optimiza el manejo de datos cruciales para laboratorios, agilizando procesos y mejorando la eficiencia en la toma de decisiones. Nuestra solución intuitiva ofrece una plataforma robusta y segura para almacenar, organizar y analizar datos con total precisión. Potencia tu laboratorio con tecnología de vanguardia y lleva la excelencia en la gestión de expedientes al siguiente nivel con Medilapp. ¡Comienza hoy mismo a transformar la forma en que gestionas tus operaciones de laboratorio!">


		<!-- Favicon -->
		<link rel="shortcut icon" href="{{asset('favicon.ico')}}">
		<link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="{{asset('vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
		
		
		
		<!-- Custom CSS -->
		<link href="{{asset('dist/css/style.css')}}" rel="stylesheet" type="text/css">
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<a href="{{route('index')}}">
                        <img class="brand-img" src="{{asset('img/logo3.png')}}" width="7%" alt="brand"/>
                        <img class="brand-img" src="{{asset('img/logo11.png')}}" width="20%" alt="brand"/>
                    </a>
				</div>
				<div class="form-group mb-0 pull-right">
					{{-- <span class="inline-block pr-10">Don't have an account?</span>
					<a class="inline-block btn btn-primary  btn-rounded btn-outline" href="signup.html">Sign Up</a> --}}
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			@yield('contenido')
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js')}}"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="{{asset('dist/js/jquery.slimscroll.js')}}"></script>
		
		<!-- Init JavaScript -->
		<script src="{{asset('dist/js/init.js')}}"></script>
		@extends('plantilla.footer')
	</body>
</html>
