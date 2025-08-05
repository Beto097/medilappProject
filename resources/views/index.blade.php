@extends('plantilla.plantilla')

@section('titulo')
    Dashboard
@endsection


@section('contenido')


    <div class="container-fluid pt-25">
        <!-- Row -->
        <div class="row">
            <x-dashboard-pacientes />
            
            @if (Auth::user()->accesoRuta('/dashboard'))

                <x-dashboard-consultas/>
            
                
            @endif
            
            
{{-- 
            <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Yearly Revenue</h6>
                        </div>
                        <div class="pull-right">
                            <div class="pull-left form-group mb-0 sm-bootstrap-select mr-15">
                                <select class="selectpicker" data-style="form-control">
                                    <option selected value='1'>Janaury</option>
                                    <option value='2'>February</option>
                                    <option value='3'>March</option>
                                    <option value='4'>April</option>
                                    <option value='5'>May</option>
                                    <option value='6'>June</option>
                                    <option value='7'>July</option>
                                    <option value='8'>August</option>
                                    <option value='9'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select>
                            </div>	
                            <a href="#" class="pull-left inline-block full-screen">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul class="flex-stat mb-10 ml-15">
                                <li class="text-left auto-width mr-60">
                                    <span class="block">Last Year</span>
                                    <span class="block txt-dark weight-500 font-18"><span class="counter-anim">3,24,222</span></span>
                                    <span class="block txt-success mt-5">
                                        <i class="zmdi zmdi-caret-up pr-5 font-20"></i><span class="weight-500">+15%</span>
                                    </span>
                                    <div class="clearfix"></div>
                                </li>
                                <li class="text-left auto-width mr-60">
                                    <span class="block">This Year</span>
                                    <span class="block txt-dark weight-500 font-18"><span class="counter-anim">1,23,432</span></span>
                                    <span class="block txt-success mt-5">
                                        <i class="zmdi zmdi-caret-up pr-5 font-20"></i><span class="weight-500">+4%</span>
                                    </span>
                                    <div class="clearfix"></div>
                                </li>
                                <li class="text-left auto-width">
                                    <span class="block">Revenue</span>
                                    <span class="block txt-dark weight-500 font-18">$<span class="counter-anim">324,222</span></span>
                                    <span class="block txt-danger mt-5">
                                        <i class="zmdi zmdi-caret-down pr-5 font-20"></i><span class="weight-500">-5%</span>
                                    </span>
                                    <div class="clearfix"></div>
                                </li>
                            </ul>
                            <div id="e_chart_1" class="" style="height:280px;"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- /Row -->
        
        <!-- Row -->
{{--         <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="calendar-wrap">
                              <div id="calendar_small" class="small-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>	
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Departmental Patients</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div id="e_chart_3" class="" style="height:346px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
               <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">General Appoinments</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <div class="pull-left inline-block dropdown mr-15">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>General</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
                                </ul>
                            </div>
                            <a class="pull-left inline-block close-panel" href="#" data-effect="fadeOut">
                                <i class="zmdi zmdi-close"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div id="e_chart_2" class="" style="height:346px;"></div>
                        </div>	
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Row -->
    </div>
@endsection


