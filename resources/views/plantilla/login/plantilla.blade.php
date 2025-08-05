<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Centro Médico Coralis - Inicio de sesión</title>
		
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
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
	</body>
</html>
