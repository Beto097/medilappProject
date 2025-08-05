


@extends('plantilla.plantilla')
@section('titulo')
    Seleccionar Pantallas
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
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Seleccionar Pantallas</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form action="{{route('rolPantalla.save')}}" method="POST" role="form" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">

                        </div>
                        <div class="col-lg-3">
                            <label for="">Seleccione un Rol</label>
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="input-group mb-3">                                    
                                <div class="col-sm-12">
                                    <select class="form-control" name="selectRol" id="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                        @foreach($roles as $fila_rol)
                                    
                                            @if($rol!='')
                                                
                                                @if($fila_rol->id == $rol->id)
                                                    <option value="{{$fila_rol->id}}" selected>{{$fila_rol->nombre_rol}} </option>
                                                @else  
                                                    <option value="{{$fila_rol->id}}">{{$fila_rol->nombre_rol}}</option>
                                                @endif
                                            @else 
                                                <option value="{{$fila_rol->id}}">{{$fila_rol->nombre_rol}}</option>
                                            @endif
                                        
                                        @endforeach
                                        
                                        
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="row" style="padding-top: 10px">
                        <div class="col-lg-12">
                            <table class="table table-striped table-inverse table-responsive">
                                <tbody>
                                    
                                    @foreach($pantallas as $pantalla)
                                    
                                        <tr>  
                                            <td scope="row"> 
                                                <div class="row ">               
                                                
                                                                    
                                                    <div class="col-md-4">
                                                        <div class="checkbox my-2">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" name="pantallas_id[]" id="pantalla{{$pantalla->id}}" value="{{$pantalla->id}}"
                                                                @if(in_array($pantalla->id, $lista_pantallas))  checked @endif
                                                                    data-parsley-multiple="groups"
                                                                    data-parsley-mincheck="2">
                                                                <label class="form-check-label"
                                                                    for="pantalla{{$pantalla->id}}">{{$pantalla->nombre_pantalla}}</label>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                
                                                    @foreach ($pantalla->sub_pantallas() as $sub_pantalla)
                                                        <div class="col-md-4">
                                                            <div class="checkbox my-2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" name="pantallas_id[]" id="pantalla{{$sub_pantalla->id}}" value="{{$sub_pantalla->id}}"
                                                                    @if(in_array($sub_pantalla->id, $lista_pantallas))  checked @endif
                                                                        data-parsley-multiple="groups"
                                                                        data-parsley-mincheck="2">
                                                                    <label class="form-check-label"
                                                                        for="pantalla{{$sub_pantalla->id}}">{{$sub_pantalla->nombre_pantalla}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    @endforeach
                                                </div> 
                                            </td>
                                        </tr>
                                   
                                        
                                    @endforeach
                                </tbody>
                              </table>
    
                        </div>
                    </div>
                    @if ($rol != '' )
                        <input type="hidden" name="txtid" id="inputtxtid" class="form-control" value="{{$rol->id}}">
                    @endif
                    <div class="modal-footer">                                        
                        <button type="submit" id="btnCrearModal"  class="btn btn-primary text-left">Guardar</button>
                    </div>
                </form>
        </div>
    </div>
</div>

@endsection




