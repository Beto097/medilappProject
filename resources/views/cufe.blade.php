@extends('plantilla.plantilla')

@section('titulo')
    Crear Paciente
@endsection





@section('contenido')   
    <br>
    <br>

    <!--muestro el error-->
    @include('plantilla.errores')
    <!-- fin del error-->
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Crear Factura</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        
                        <form action="{{route('cufe.insert')}}" method="POST" role="form" autocomplete="off">
                            @csrf
                            <div class="row">
                                
                                
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label mb-10 text-left">Datos</label>
                                    <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" name="txtComentario" rows="10">{{old ('txtComentario')}}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 " style="padding-top: 2rem">   
                                    <div class="modal-footer">
                                                                        
                                        
                                        <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Generar Factura</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
    

@endsection

