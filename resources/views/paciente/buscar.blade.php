@extends('plantilla.plantilla')

@section('titulo')
    Buscar Paciente
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
                        <h6 class="panel-title txt-dark">Buscar Paciente</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                    <div class="panel-body">
                        
                        <form action="{{route('paciente.buscar')}}" method="POST" role="form" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12 col-xs-12" id="cedulaDiv">                                    
                                    <label class="control-label mb-10 text-left"></label>
                                    <input type="text" class="form-control"  name="txtTexto" id="txtTexto" placeholder="texto a buscar"  
                                        value="{{old ('txtTexto')}}" required>
                                    <small id="AlertaTexto" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                                                
                                <a href="{{route('paciente.index')}}" id="btnCrearModal"  class="btn btn-danger text-rigth">Cancelar</a>
                                <button type="submit" id="btnCrear"  class="btn btn-primary text-left">Buscar Paciente</button>
                            </div>
                            
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
    

@endsection

