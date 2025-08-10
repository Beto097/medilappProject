@extends('plantilla.plantilla')
@section('titulo')
    Editar Examen
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
                    <h4>Actualizar Examen</h4>
                    <h6>Paso 1: Ingrese los datos para crear un examen</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <form action="{{route('examen.save')}}" method="POST" role="form" autocomplete="off">
                @csrf
                
                <div class="row" style="padding-top: 15px">      
                    <div class="form-group col-md-12">
                        <label for="">Nombre del Examen</label>
                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Tipaje" name="txtNombre" value="{{$examen->nombre_examen}}"  required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">Tipo de Examen</label>
                        <select class="form-control" id="cbxTipoExamen" name="cbxTipoExamen">
                            @if ($examen->tipo_examen->estado_tipo_examen == 0)
                                <option value="0">Se puede dividir este examen</option>
                            @else
                                <option value="">Seleccione un tipo de Examen</option>
                                @foreach ($tipo_examenes as $tipo_examen)
                                    <option value="{{ $tipo_examen->id }}" {{ $examen->tipo_examen_id == $tipo_examen->id ? 'selected' : '' }}>
                                        {{ $tipo_examen->nombre_tipo_examen }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">El Examen contiene valor de referencia:</label>
                        <select class="form-control" id="cbxReferencia" name="cbxReferencia">
                            <option value="0" {{ $examen->tiene_referencia == "0" ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $examen->tiene_referencia == "1" ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="">Descripcion del Examen</label>
                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" placeholder="Escriba una breve descripcion del examen">{{$detalle_examen}}</textarea>
                    </div>

                    
                </div>

                <div class="modal-footer">                                        
                    <div class="row justify-content-around" >
                        <input type="hidden" name="txtid" id="inputtxtid" class="form-control" value="{{$examen->id}}">
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
