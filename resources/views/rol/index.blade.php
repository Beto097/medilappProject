@extends('plantilla.plantillaDT')

@section('titulo')
    Roles
@endsection


@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los roles que estan registrados en el sistema.</p>
        </div>
        <div class="col-sm-2">
          @if(Auth::user()->accesoRuta('/rol/create'))
            <button class="btn btn-primary btn-lable-wrap left-label" id="addNewRol" data-toggle="modal" data-target="#addNewRolModal"> 
              <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                Agregar Rol
              </span>
            </button>
            @include('modals.RolModals')  
             
          @endif

        </div>
        <br>
        <br>
        <br>
            <div class="col-sm-4 col-sm-offset-8">
          @include('plantilla.errores')
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Roles</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display  pb-30" cellspacing="0"  style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>                                          
                                        <th>Acciones</th>
                                      </tr>
                                      
                                    </thead>
                                    
                                    <tbody>
                                      @foreach ($resultado as $fila)
                                        <tr style="font-size: 100%;">
                                          <td>{{$fila->id}}</td>
                                          <td>{{$fila->nombre_rol}}</td>                                                               
                                          <td>
                                            
                                            
              
                                            @if (Auth::user()->accesoRuta('/rol/update'))
                                            
                                              <button type="button" class="btn btn-success btn-sm" id="editRol"                
                                                  data-toggle="modal" data-target="#editarRolModal{{$fila->id}}">
                                                  <i class="fa fa-edit"></i>
                                              </button>
                                              @include('modals.editarRolModals')
                                            @endif
                                            
              
                                            @if (Auth::user()->accesoRuta('/rol/delete'))    
                                                                                  
                                              <a class="btn btn-danger btn-sm"title="Eliminar el rol" href="{{route('rol.delete', ['id' => $fila->id])}}" onclick="
                                                  return confirm('Desea eliminar este pantalla del sistema?')"><i class="fa fa-trash-o"></i></a> 

                                            @endif
                                            
                                          </td>
                                        </tr>
                                      @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                      <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>                                          
                                        <th>Acciones</th>
                                      </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
@endsection

@section('ordenarTabla')

    ,"order": [[0,'desc']]
     ,"columns": [      
      null,
      null,
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection






