@extends('plantilla.plantillaDT')

@section('titulo')
    Sucursal
@endsection

@section('css')    
    @include('scripts.validaciones')
@endsection

@section('contenido')
    				
    <div class="row">
        <br>
        <div class="col-sm-10">
            <p>Este listado muestra todos las Sucursales en el sistema</p>
        </div>
        <div class="col-sm-2">
            @if (Auth::user()->accesoRuta('/sucursal/create'))  
                <button class="btn btn-primary btn-lable-wrap left-label" id="addNewSucursal" data-toggle="modal" data-target="#addNewSucursalModal">
                    <span class="btn-label"><i class="fa fa-folder-o"></i> </span><span class="btn-text">
                        Agregar Sucursal
                    </span>
                </button>
                @include('modals.SucursalModals')
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
                        <h6 class="panel-title txt-dark">Sucursales</h6>
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
                                            <th>Telefono</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($resultado as $fila)
                                            <tr style="font-size: 90%;">
                                                <td scope="row">{{$fila->id }}</td>                                                
                                                <td>{{ $fila->nombre_sucursal }}</td>                                                
                                                <td>{{ $fila->telefono_sucursal }}</td>
                                                <td>
                                                    @if (Auth::user()->accesoRuta('/sucursal/update'))  
                                                        <button type="button" class="btn btn-success btn-sm" id="editSucursal"                
                                                            data-toggle="modal" data-target="#editarSucursalModal{{$fila->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @include('modals.editarSucursalModals')
                                                    @endif
                                                    @if (Auth::user()->accesoRuta('/sucursal/delete'))  
                                                        
                                                        @if($fila->estado_sucursal == 1)                                        
                                                            <a class="btn btn-danger btn-sm"title="Eliminar la Sucursal" href="{{route('sucursal.delete', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea eliminar esta Sucursal del sistema?')"><i class="fa fa-trash-o"></i></a> 
                                                        @else
                                                            <a class="btn btn-warning btn-sm" title="Desbloquear la Sucursal" href="{{route('sucursal.desbloquear', ['id' => $fila->id])}}" onclick="
                                                                return confirm('Desea desbloquear esta Sucursal del sistema?')"><i class="fa fa-unlock-alt"></i></a> 
                                                        @endif
                                                    @endif                                                        
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>                                            
                                            <th>Telefono</th>
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