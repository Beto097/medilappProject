@extends('plantilla.plantillaDT')

@section('titulo')
    Caracteristicas de Examenes
@endsection

@section('css')    
    @include('scripts.validaciones')
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos caracteristicas en el sistema</p>
        </div>
        <div class="col-sm-2">
            @if (Auth::user()->accesoRuta('/caracteristicaExamen/create'))  
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewCaracteristicaExamen" data-toggle="modal" data-target="#addNewCaracteristicaExamenModal">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Agregar Caracteristica
                    </span>
                </button>
                @include('modals.CaracteristicaExamenModals')
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
                        <h6 class="panel-title txt-dark">Caracteristicas de Examenes</h6>
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
                                            <th>Unidad</th>
                                            <th>Valor</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr style="font-size: 90%;">
                                                <td scope="row">{{ $fila->id }}</td>
                                                <td>{{$fila->nombre_caracteristica_examen}}</td>
                                                <td>{{$fila->unidad_caracteristica_examen}}</td>
                                                <td>{!!$fila->valor_referencia_caracteristica_examen!!}</td>
                                                <td>
                                                    @if (Auth::user()->accesoRuta('/caracteristicaExamen/update'))  
                                                        <button type="button" class="btn btn-success btn-sm" id="editMedico"                
                                                            data-toggle="modal" data-target="#editarCaracteristicaModal{{$fila->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @include('modals.editarCaracteristicaModals')
                                                    
                                                    @endif
                                                    @if (Auth::user()->accesoRuta('/caracteristicaExamen/delete'))  
                                                        
                                                        
                                                            <a class="btn btn-danger btn-sm" title="Eliminar Caracterista" href="{{ route('caracteristica_examen.delete', ['id' => $fila->id]) }}" onclick="
                                                                return confirm('Desea eliminar esta caracteristica del sistema?')"><i id="iconoBoton"  class="fa fa-trash-o"></i>
                                                            </a>                                        
                                                            
                                                        
                                                    @endif                                                        
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Unidad</th>
                                            <th>Valor</th>                                           
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
      null,
      { "width": "20%" }
    ],
    "pageLength": 15,
    lengthMenu: [15, 30, 50, 100],
    

@endsection