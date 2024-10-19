<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap">
                <a href="{{route('index')}}">
                    <img class="brand-img"  src="{{asset('img/logo15.png')}}" alt="brand"/> 
                    <img class="brand-img1" src="{{asset('img/logo11.png')}}"/>
                </a>
            </div>
        </div>	
        <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
        @if (Auth::user()->rol_id==1)
            
            <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
            <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
            <form id="search_form" role="search" class="top-nav-search collapse pull-left">
                <div class="input-group">
                    <input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                    <button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
                    </span>
                </div>
            </form>
        @endif
    </div>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right">
        <ul class="nav navbar-right top-nav pull-right">
            @if (Auth::user()->rol_id==1)
                <li class="dropdown auth-drp">
                    <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
                        
                        @if (Session::has('dataBaseName'))
                            {{Session::get('companyName')}}
                        @else
                            Compañias
                        @endif
                        
                    </a>
                    <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <li>
                            <a href="{{route('seleccionar.company',['id'=>0])}}"><span>Sin Compañia</span></a>
                        </li>
                        @foreach (Auth::user()->rol->companys() as $company)
                            <li>
                                <a href="{{route('seleccionar.company',['id'=>$company->id])}}"><span>{{$company->company_name}}</span></a>
                            </li>
                        @endforeach
                        
                        
                    </ul>
            </li>
            @endif
            
            @if (Auth::user()->rol_id==1)
                <li>
                    <a id="open_right_sidebar" href="#"><i class="zmdi zmdi-settings top-nav-icon"></i></a>
                </li>
            @endif
            <li class="dropdown app-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps top-nav-icon"></i></a>
                <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                    <li>
                        <div class="app-nicescroll-bar">
                            <ul class="app-icon-wrap pa-10">
                                @foreach (Auth::user()->rol->pantallas as $pantalla_menu)
                                    @if ($pantalla_menu->padre == 0  and $pantalla_menu->estado_pantalla==1 and $pantalla_menu->url_pantalla <>'#')
                                        <li>
                                            <a href="{{$pantalla_menu->url_pantalla}}" class="connection-item">
                                            <i class="{{$pantalla_menu->icono_pantalla}} {{$pantalla_menu->color_pantalla}}"></i>
                                            <span class="block">{{$pantalla_menu->nombre_pantalla}}</span>
                                            </a>
                                        </li>
                                    @endif 
                                @endforeach
                               
                            </ul>
                        </div>	
                    </li>
                   
                </ul>
            </li>
            @if (Auth::user()->rol_id==1)
                <li class="dropdown full-width-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-more-vert top-nav-icon"></i></a>
                    <ul class="dropdown-menu mega-menu pa-0" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li class="product-nicescroll-bar row">
                            <ul class="pa-20">
                                <li class="col-md-3 col-xs-6 col-menu-list">
                                    <a href="javascript:void(0);"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                                    <hr class="light-grey-hr ma-0"/>
                                    <ul>
                                        <li>
                                            <a href="index.html">Analytical</a>
                                        </li>
                                        <li>
                                            <a href="index2.html">Demographic</a>
                                        </li>
                                        <li>
                                            <a href="index3.html">Project</a>
                                        </li>
                                        <li>
                                            <a href="index4.html">Hospital</a>
                                        </li>
                                        <li>
                                            <a href="index5.html">HRM</a>
                                        </li>
                                        <li>
                                            <a href="index6.html">Real Estate</a>
                                        </li>
                                        <li>
                                            <a href="profile.html">profile</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-md-3 col-xs-6 col-menu-list">
                                    <a href="javascript:void(0);">
                                        <div class="pull-left">
                                            <i class="zmdi zmdi-shopping-basket mr-20"></i><span class="right-nav-text">E-Commerce</span>
                                        </div>	
                                        <div class="pull-right"><span class="label label-primary">hot</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                    <hr class="light-grey-hr ma-0"/>
                                    <ul>
                                        <li>
                                            <a href="e-commerce.html">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="product.html">Products</a>
                                        </li>
                                        <li>
                                            <a href="product-detail.html">Product Detail</a>
                                        </li>
                                        <li>
                                            <a href="add-products.html">Add Product</a>
                                        </li>
                                        <li>
                                            <a href="product-orders.html">Orders</a>
                                        </li>
                                        <li>
                                            <a href="product-cart.html">Cart</a>
                                        </li>
                                        <li>
                                            <a href="product-checkout.html">Checkout</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-md-6 col-xs-12 preview-carousel">
                                    <a href="javascript:void(0);"><div class="pull-left"><span class="right-nav-text">latest products</span></div><div class="clearfix"></div></a>
                                    <hr class="light-grey-hr ma-0"/>
                                    <div class="product-carousel owl-carousel owl-theme text-center">
                                        <a href="#">
                                            <img src="../img/chair.jpg" alt="chair">
                                            <span>Circle chair</span>
                                        </a>
                                        <a href="#">
                                            <img src="../img/chair2.jpg" alt="chair">
                                            <span>square chair</span>
                                        </a>
                                        <a href="#">
                                            <img src="../img/chair3.jpg" alt="chair">
                                            <span>semi circle chair</span>
                                        </a>
                                        <a href="#">
                                            <img src="../img/chair4.jpg" alt="chair">
                                            <span>wooden chair</span>
                                        </a>
                                        <a href="#">
                                            <img src="../img/chair2.jpg" alt="chair">
                                            <span>square chair</span>
                                        </a>								
                                    </div>
                                </li>
                            </ul>
                        </li>	
                    </ul>
                </li>
            @endif
            <li class="dropdown alert-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i>
                    
                        @if ($cantidad_notificaciones>0)
                            <span class="top-nav-icon-badge">
                                {{$cantidad_notificaciones}}
                            </span>
                        @endif
                </a>
                <ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
                    <li>
                        <div class="notification-box-head-wrap">
                            <span class="notification-box-head pull-left inline-block">Notificaciones</span>
                            <a class="txt-danger pull-right clear-notifications inline-block" href="{{route('notificacion.borrarTodas')}}"> Borrar Todas </a>
                            <div class="clearfix"></div>
                            <hr class="light-grey-hr ma-0"/>
                        </div>
                    </li>
                    <li>
                        <div class="streamline message-nicescroll-bar">
                            @if ($cantidad_notificaciones==0)
                            <div class="sl-item">
                                <a href="javascript:void(0)">                                    
                                    <div class="sl-content">
                                        <span class="inline-block capitalize-font  pull-left truncate head-notifications">
                                            Sin Notificaciones
                                        </span>
                                    </div>
                                </a>	
                            </div>
                            <hr class="light-grey-hr ma-0"/>
                            @else
                                
                                @foreach ($notificaciones as $notificacion)
                                    @if ($notificacion->type =='App\Notifications\notificacionsOrdenes')

                                        <?php
                                            $data = json_decode($notificacion->data, true);
                                                    
                                            $id_orden =  $data["orden_id"]; 
                                        ?>
                                        <div class="sl-item">
                                            <a href="{{route('notificacion.orden', ['id'=> $id_orden] )}}">
                                                <div class="icon bg-green">
                                                    <i class="zmdi zmdi-flag"></i>
                                                </div>
                                                <div class="sl-content">
                                                    <span class="inline-block capitalize-font  pull-left truncate head-notifications">
                                                    Nueva Orden de Laboratorio
                                                    </span>
                                                    <span class="inline-block font-11  pull-right notifications-time">{{Carbon\Carbon::parse($notificacion->created_at)->diffForHumans()}}</span>
                                                    <div class="clearfix"></div>
                                                    <p class="truncate">
                                                        <?php
                                                            $data = json_decode($notificacion->data, true);
                                                                    
                                                            echo $data["mensaje"]; 
                                                        ?>
                                                    </p>
                                                </div>
                                            </a>	
                                        </div>
                                        <hr class="light-grey-hr ma-0"/>
                                        
                                    @endif 
                                    @if ($notificacion->type =='App\Notifications\ordenTerminada')
                                        
                                        <?php
                                            $data = json_decode($notificacion->data, true);
                                                    
                                            $id_orden =  $data["orden_id"]; 
                                        ?>
                                        <div class="sl-item">
                                            <a href="{{route('notificacion.ordenTerminada', ['id'=> $id_orden] )}}">
                                                <div class="icon bg-blue">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                                <div class="sl-content">
                                                    <span class="inline-block capitalize-font  pull-left truncate head-notifications">Orden Terminada</span>
                                                    <span class="inline-block font-11  pull-right notifications-time">{{Carbon\Carbon::parse($notificacion->created_at)->diffForHumans()}}</span>
                                                    <div class="clearfix"></div>
                                                    <p class="truncate">
                                                        <?php
                                                            $data = json_decode($notificacion->data, true);
                                                                    
                                                            echo $data["mensaje"]; 
                                                        ?>
                                                    </p>
                                                </div>
                                            </a>	
                                        </div>
                                        <hr class="light-grey-hr ma-0"/>
                                       
                                    @endif 
                                    @if ($notificacion->type =='App\Notifications\nuevoUsuario')
                                        <?php
                                            $data = json_decode($notificacion->data, true);
                                                    
                                            $identificacion =  $data["identificacion_paciente"]; 
                                        ?>
                                        <div class="sl-item">
                                            <a href="{{route('paciente.verPassword', ['id'=> $identificacion ] )}}">
                                                <div class="icon bg-yellow">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="sl-content">
                                                    <span class="inline-block capitalize-font  pull-left truncate head-notifications">Nuevo Usuario</span>
                                                    <span class="inline-block font-11  pull-right notifications-time">{{Carbon\Carbon::parse($notificacion->created_at)->diffForHumans()}}</span>
                                                    <div class="clearfix"></div>
                                                    <p class="truncate">
                                                        <?php
                                                            $data = json_decode($notificacion->data, true);
                                                                    
                                                            echo $data["mensaje"]; 
                                                        ?>
                                                    </p>
                                                </div>
                                            </a>	
                                        </div>
                                        <hr class="light-grey-hr ma-0"/>                                        
                                        
                                    @endif 
                                    
                                @endforeach
                            @endif                            
                            
                        </div>
                    </li>
                    <li>
                        <div class="notification-box-bottom-wrap">
                            <hr class="light-grey-hr ma-0"/>
                            <a class="block text-center read-all" href="javascript:void(0)"> read all </a>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown auth-drp">
                <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
                    
                        {{Auth::user()->nombre_usuario}}
                    
                </a>
                <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    
                    @if (Auth::user())
                        <li>
                            <a href="{{route('usuario.update.password', ['id' => Auth::user()->id])}}"><i class="zmdi zmdi-lock"></i><span>Cambiar Contraseña</span></a>
                        </li>                                    
                    @endif
                    
                    
                   
                    <li class="divider"></li>
                    <li>
                        <a href="{{route('login.cerrar')}}"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>	
</nav>