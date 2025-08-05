@extends('plantilla.plantillaDT')

@section('titulo')
    Pantallas
@endsection


@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos los pantallas que estan registrados en el sistema.</p>
        </div>
        <div class="col-sm-2">
          @if(Auth::user()->accesoRuta('/pantalla/create'))
            <button class="btn btn-primary btn-lable-wrap left-label" id="addNewPantalla" data-toggle="modal" data-target="#addNewPantallaModal"> 
              <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                Agregar Pantalla
              </span>
            </button>
            @include('modals.PantallaModals')  
             
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
                        <h6 class="panel-title txt-dark">Pantallas</h6>
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
                                        <th>URL</th>       
                                        <th>Acciones</th>
                                      </tr>
                                      
                                    </thead>
                                    
                                    <tbody>
                                      @foreach ($resultado as $fila)
                                        <tr style="font-size: 100%;">
                                          <td>{{$fila->id}}</td>
                                          <td>{{$fila->nombre_pantalla}}</td> 
                                          <td>{{$fila->url_pantalla}}</td>                        
                                          <td>
                                            
                                            
              
                                            @if (Auth::user()->accesoRuta('/pantalla/update'))
                                            
                                              <button type="button" class="btn btn-success btn-sm" id="editPantalla"                
                                                  data-toggle="modal" data-target="#editarPantallaModal{{$fila->id}}">
                                                  <i class="fa fa-edit"></i>
                                              </button>
                                              @include('modals.editarPantallaModals')
                                            @endif
                                            
              
                                            @if (Auth::user()->accesoRuta('/pantalla/delete'))    
                                                                                  
                                              <a class="btn btn-danger btn-sm"title="Eliminar el pantalla" href="{{route('pantalla.delete', ['id' => $fila->id])}}" onclick="
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
                                        <th>URL</th>       
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
      null,
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection






