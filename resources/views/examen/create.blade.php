@extends('plantilla.plantilla')
@section('titulo')
    Crear Examen
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
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="text-center">  
                    <h4>Crear Nuevo Examen</h4>
                    <h6>Paso 1: Ingrese los datos para crear un examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route('examen.insert')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
                <div class="row" style="padding-top: 15px">      
                    <div class="form-group col-md-12">
                        <label for="">Nombre del Examen</label>
                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Tipaje" name="txtNombre" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">Tipo de Examen</label>
                        <select class="form-control" id="cbxTipoExamen" name="cbxTipoExamen">
                            <option value='0'>Se puede dividir este examen</option>
                            @foreach($tipo_examenes as $tipo_examen)
                            <option value="{{$tipo_examen->id}}">{{$tipo_examen->nombre_tipo_examen}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">El Examen contiene valor de referencia:</label>
                        <select class="form-control" id="cbxReferencia" name="cbxReferencia">
                            
                            
                            <option value="0">No</option>
                            <option value="1">Si</option>
                            
                        </select>
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="">Descripcion del Examen</label>
                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Escriba una breve descripcion del examen"></textarea>
                    </div>

                    
                </div>

                <div class="modal-footer">                                        
                    <div class="row justify-content-around" >
                        
                        <div class="col-4">   
                            <a href="{{ route('examen.index') }}" class="btn btn-danger btn-lg" role="button" aria-pressed="true">Cancelar</a>           
                            <button type="submit" class="btn btn-primary btn-lg">Siguiente</button>
                        </div>
                    </div>
                </div>
                
                
            </form>
        </div>
    </div>
</div>

@endsection
