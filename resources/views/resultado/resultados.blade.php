@extends('plantilla.plantilla')

@section('titulo')
   Ingresar Resultados de Examen
@endsection

@section('css')
    <style>
        .form-section {
            border-left: 4px solid #4e73df;
            padding-left: 1rem;
        }
        .exam-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .result-input {
            border: 2px solid #e3e6f0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .result-input:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
    </style>
@endsection

@section('logopantalla')
    <i class="fas fa-flask"></i>
@endsection

@section('titulopantalla')
    Ingresar Resultados
@endsection

@section('opcionmenu')
<li class="nav-item">
    <a id="medicoa" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opcionesmedico" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-user-md"></i>
      <span>Examenes</span>
    </a>
    <div id="opcionesmedico" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Opciones Medico:</h6>
        <a class="collapse-item" href="{{ route('medico.crear') }}">Insertar medico</a>
        <a class="collapse-item" href="register.html">Register</a>
        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
      </div>
    </div>
  </li>
@endsection

@section('contenido')
    <div class="container-fluid">

       
        <!--muestro el error-->
        @error('status')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>

        <script>
            $(".alert").alert();

        </script>
        @enderror
        <!-- fin del error-->      

       
        
        <div class="d-flex">
            <div class="mr-auto p-2 "><p class="mb-4"></a></p></div>
            
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center"><h3>Orden de Laboratorio Nº: {{$orden->id}}</h3></div>
                
                <div class="col-md-5"><h4>Paciente: {{$orden->paciente->nombre_paciente}} {{$orden->paciente->apellido_paciente}}</h4></div>
                <div class="col-md-5 text-right"><h4>Identificacion: {{$orden->paciente->identificacion_paciente}}</h4></div>
                <div class="col-md-5"><h4>Sexo: 
                    @if($orden->paciente->sexo_paciente == 'm')
                        Masculino
                    @else
                        Femenino
                    @endif
                
                </h4></div>
                <div class="col-md-5 text-right"><h4>Edad: {{$edad_paciente}} años</h4></div>
                <div class="col-md-5"><h4>Medico: {{$orden->medico->nombre_medico}}-{{$orden->medico->numero_registro}}</h4></div>                
                <div class="col-md-5 text-right"><h4>Fecha: {{$orden->fecha_orden}}</h4></div>
                <div class="col-md-10 text-right"><h4>Estado: {{$orden->estado_orden_laboratorio}}</h4></div>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-center">{{$examen->nombre_examen}}</h2>
            </div>
            <div class="card-body">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center"><h3>{{$examen->tipo_examen->nombre_tipo_examen}}</h3></div>
                    
                        @if ($examen->tiene_referencia =='1')
                            <div class="col-md-3"><h4>PRUEBA</h4></div> 
                            <div class="col-md-3"><h4>RESULTADO</div>
                            <div class="col-md-2"><h4>UNIDAD</div>
                            <div class="col-md-4"><h4>VALOR DE REFERENCIA</h4></div>
                        @else
                            
                            <div class="col-md-3"><h4>PRUEBA</h4></div> 
                            <div class="col-md-3"><h4>RESULTADO</div>
                            <div class="col-md-3"><h4></h4></div> 
                            <div class="col-md-3"><h4></h4></div> 
                        @endif
                        

                    </div>
                    <br>

                    <form action="{{route('insertar.resultados',['id'=>$examen->id])}}" method="POST" role="form" autocomplete="off">
                        @csrf
                        <div class="row justify-content-center">
                            @if ($examen->tiene_referencia =='1')
                                @foreach($caracteristicas as $caracteristica_examen)
                                    <div class="col-md-3"><h5>{{$caracteristica_examen->caracteristica_examen->nombre_caracteristica_examen}}</h5></div>
                                    @if ($caracteristica_examen->caracteristica_examen->es_obligatorio =='1')
                                        <div class="form-group col-md-3">                                    
                                            <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]" required>
                                            
                                        </div> 
                                    @else
                                        <div class="form-group col-md-3">                                    
                                            <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]">
                                            
                                        </div> 
                                        
                                    @endif
                                    
                                    <input type="hidden" name="caracteristica_id[] id="input" class="form-control" value="{{ $caracteristica_examen->caracteristica_examen->id}}"> 
                                    
                                    <div class="col-md-2"><h5>{{$caracteristica_examen->caracteristica_examen->unidad_caracteristica_examen}}</h5></div>
                                    <div class="col-md-4"><h5>{!!$caracteristica_examen->caracteristica_examen->valor_referencia_caracteristica_examen!!}</h5></div>
                                                            
                                    
                                @endforeach
                            @else 
                                @foreach($caracteristicas as $caracteristica_examen)
                                    
                                    <div class="col-md-3"><h5>{{$caracteristica_examen->caracteristica_examen->nombre_caracteristica_examen}}</h5></div>
                                    @if ($caracteristica_examen->caracteristica_examen->es_obligatorio =='1')
                                        <div class="form-group col-md-3">                                    
                                            <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]" required>
                                            
                                        </div> 
                                    @else
                                        <div class="form-group col-md-3">                                    
                                            <input type="text" class="form-control" name="valores[{{$caracteristica_examen->caracteristica_examen->id}}]">
                                            
                                        </div> 
                                        
                                    @endif
                                    <input type="hidden" name="caracteristica_id[] id="input" class="form-control" value="{{ $caracteristica_examen->caracteristica_examen->id}}"> 
                                    <div class="col-md-3"><h4></h4></div> 
                                    <div class="col-md-3"><h4></h4></div> 
                                @endforeach
                            @endif 
                            
                        </div> 
                        <div class="row " hidden id="observacionesDiv">
                            <div class="col-md-3"><h4>Observaciones:</h4></div>
                                <div class="form-group col-md-6">

                                    <textarea class="form-control" name="txtObservaciones" id=""  rows="3"></textarea>                                
                                    
                                    
                                </div> 
                        </div>  

                        <input type="hidden" name="txtExamenOrdenLaboratorioId" id="input" class="form-control" value="{{ $examen_orden->id }}">
                        
                        
                       
                        <div class="row" > 
                            <div class="col-8" > 
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="observaciones" name="Observaciones" onclick="cambiarBoton();">
                                    <label class="custom-control-label" for="observaciones">Desea Agregar Observaciones</label>
                                </div>
                               
                            </div>

                            
                        
                        </div>
                        <div class="col-md-12"><h4>{!!$examen->detalle_examen!!}</h4></div>
                        <div class="row justify-content-around"> 
                            <div class="col-3"> 
                                <button type="submit" id="botoncrear" class="btn btn-primary btn-lg"><i class="fas fa-check"></i> Guardar</button>
                            </div>

                            <div class="col-3">
                                <a href="{{route('ordenLaboratorio.examenes',['id' =>$orden->id])}}" class="btn btn-danger  btn-lg"><i class="fas fa-times"></i> Cancelar</a>
                            </div>
                        
                        </div>
                        
                    </form>
                        
                </div>
                
            </div>
        </div>

    </div>

@endsection

@section('footer')
    @include('plantilla.footer')
@endsection

@section('js')
<script>
    function cambiarBoton(){
        if (document.getElementById('observaciones').checked){
            document.getElementById('observacionesDiv').hidden = false;
        } else {
            document.getElementById('observacionesDiv').hidden = true;
        }
    }
    
    $(document).ready(function() {
        // Validaciones del formulario
        $('#formResultados').on('submit', function(e) {
            let valid = true;
            let requiredFields = $('input[required], textarea[required]');
            
            requiredFields.each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos');
            }
        });
    });
</script>
@endsection
@section('contenidofooter')

@show
@endsection
