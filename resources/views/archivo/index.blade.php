@extends('plantilla.plantillaDT')

@section('titulo')
   Archivos del Paciente {{$paciente->identificacion_paciente}}
@endsection





@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            
        </div>
        <div class="col-sm-2">
          @if(Auth::user()->accesoRuta('/archivo/insertar'))
            <button class="btn btn-primary btn-lable-wrap left-label" id="addNewFile" title="Cargar Archivo" data-toggle="modal" data-target="#addNewFileModal">
              <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                Agregar Archivo
              </span>
            </button>
            @include('modals.FileModals2')
       
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
                        <h6 class="panel-title txt-dark">
                        
                          Listado de Archivos de {{$paciente->nombre_paciente}} {{$paciente->apellido_paciente}}
                        </h6>
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
                                        <th>Nombre</th>                
                                        <th>Fecha</th> 
                                        <th>Acciones</th>                                   
                                      </tr>
                                    </thead>
                                    
                                    <tbody>
                                    
                                    @foreach ($paciente->archivos as $key=>$archivo)
                                        
                                      
                                        <tr style="font-size: 100%;">
                                            
                                          <td><a href="{{ asset($archivo->ruta) }}" target="_blank">{{ $archivo->nombre }}</a></td>
                                          <td> {{\Carbon\Carbon::parse($archivo->created_at)->format('d/m/Y')}}</td>      
                                          <td>
                                            @if(Auth::user()->accesoRuta('/archivo/ver'))
                                              <a class="btn btn-success btn-sm btnIcono" title="Ver Archivo" href="{{ asset($archivo->ruta) }}" target="_blank">
                                                <i id="iconoBoton" class="fa fa-eye"></i>
                                              </a>
                                            @endif
                                            @if(Auth::user()->accesoRuta('/archivo/delete'))
                                              <a class="btn btn-danger btn-sm btnIcono" title="Eliminar Archivo" href="{{route('archivo.delete', ['id'=> $archivo->id] )}}" onclick="
                                                return confirm('Desea eliminar este archivo del sistema?')"><i id="iconoBoton" class="fa fa-trash"></i>
                                              </a>
                                            @endif
                                          </td>
                                        </tr>
                                        
                                      
                                      @endforeach
                                      
                                    </tbody>
                                
                                    <tfoot>
                                      <tr>
                                        <th>Nombre</th>                
                                        <th>Fecha</th>
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
      { "width": "30%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection






