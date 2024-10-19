@extends('plantilla.plantilla')

@section('titulo')
    Seleccionar Pantallas
@endsection



@section('contenido')   
    <br>
    <br>

    <!--muestro el error-->
    @include('plantilla.errores')
    <!-- fin del error-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Seleccionar Pantallas</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        
                        <form action="{{route ('rolPantalla.save')}}" method="POST" role="form" autocomplete="off">
                            @csrf

                            <div class="row">                                
                                <div class="form-group col-md-4 col-sm-4 col-xs-4 col-sm-offset-3 col-md-offset-3 col-xs-offset-4">
                                    <label for="exampleFormControlSelect1"></label>
                                    <select class="form-control"  name="selectRol" id="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                        @foreach($roles as $fila_rol)
                                          @if($fila_rol->id == $rol->id)
                                            <option value="{{$fila_rol->id}}" selected>{{$fila_rol->nombre_rol}}</option>
                                          @else  
                                            <option value="{{$fila_rol->id}}">{{$fila_rol->nombre_rol}}</option>
                                          @endif
                                        @endforeach
                                        
                                    </select>    
                                </div>
                            </div>
                            <table class="table table-striped table-inverse table-responsive">
                                <tbody>
                                  @foreach($pantallas as $pantalla)
                                    @if ($pantalla->padre ==0)
                                      <tr>  
                                        <td scope="row"> 
                                          <div class="row ">               
                                            
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="pantallas_id[]" id="checkbox{{$pantalla->id}}" value="{{$pantalla->id}}" @if(in_array($pantalla->id, $lista_pantallas))   checked @endif>
                                                    <label class="form-check-label" for="checkbox{{$pantalla->id}}">
                                                        <h5>{{$pantalla->nombre_pantalla}}</h5>
                                                    </label>
                                                  </div>                                                    
                                            </div>                
                      
                                           

                      
                                            
                                            @foreach ($pantallas as $sub_pantalla)
                                              @if ($sub_pantalla->padre == $pantalla->id)
                                                
                                                
                      
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="pantallas_id[]" id="checkbox{{$sub_pantalla->id}}" value="{{$sub_pantalla->id}}" @if(in_array($sub_pantalla->id, $lista_pantallas))   checked @endif>
                                                        <label class="form-check-label" for="checkbox{{$sub_pantalla->id}}">
                                                            <h5>{{$sub_pantalla->nombre_pantalla}}</h5>
                                                        </label>
                                                      </div>                                                    
                                                </div>
                      
                                                
                                                  
                                              @endif
                                              
                                                
                                            @endforeach
                                          </div> 
                                        </td>
                                      </tr>
                                    @endif
                                        
                                  @endforeach
                                </tbody>
                              </table>
                                  
                            @if (Auth::user()->permisos('rol','update'))
                                <div class="modal-footer">
                                    <input type="hidden" name="txtId" id="inputtxtid" class="form-control" value="{{$rol->id}}">                    
                                    <a href="" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                                    <button type="submit" id="btnGuardar"  class="btn btn-primary text-left">Guardar</button>
                                </div>
                            @endif 
                            
                           
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
    

@endsection
