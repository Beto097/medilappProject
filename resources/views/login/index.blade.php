@extends('plantilla.login.plantilla')

@section('contenido')
<div class="page-wrapper pa-0 ma-0 auth-page">
    <div class="container-fluid">
        <!-- Row -->
        <div class="table-struct full-width full-height">
            <div class="table-cell vertical-align-middle auth-form-wrap">
                <div class="auth-form  ml-auto mr-auto no-float">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="mb-30">
                                <h3 class="text-center txt-dark mb-10">INICIAR SESIÓN</h3>
                                <h6 class="text-center nonecase-font txt-grey">introduzca sus datos a continuación</h6>
                            </div>	
                            @if (count($errors) > 0)

                                <div class="alert alert-danger alert-dismissable alert-style-1">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="zmdi zmdi-block"></i>Algo salio mal..
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                    
                                </div>
                                
                            @endif
                            <div class="form-wrap">
                                <form action="" method="POST" role="form" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label  mb-10" for="exampleInputEmail_2">Usuario</label>
                                        <input type="text" class="form-control" value="{{ old('usuario') }}" name="usuario" required id="exampleInputEmail_2" placeholder="introduzca su nombre de usuario">
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Contraseña</label>
                                        {{-- <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a> --}}
                                        <div class="clearfix"></div>
                                        <input type="password" class="form-control" required value="{{ old('password') }}" name="password" id="exampleInputpwd_2" placeholder="introduzca su contraseña">
                                    </div>
                                    
                                    {{-- <div class="form-group">
                                        <div class="checkbox checkbox-primary pr-10 pull-left">
                                            <input id="checkbox_2" required="" type="checkbox">
                                            <label for="checkbox_2"> Keep me logged in</label>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div> --}}
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary  btn-rounded">ingresar</button>
                                    </div>
                                </form>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->	
    </div>
    
</div>
    
@endsection