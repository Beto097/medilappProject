@extends('plantilla.plantilla')

@section('titulo')
   Ver Resultados de Examen
@endsection

@section('css')
    <style>
        .result-card {
            border-left: 4px solid #28a745;
        }
        .exam-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .result-value {
            font-weight: 600;
            color: #495057;
        }
        .reference-value {
            font-size: 0.875rem;
            color: #6c757d;
        }
        .print-btn {
            background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
            border: none;
            color: white;
        }
        .print-btn:hover {
            background: linear-gradient(135deg, #5a2d91 0%, #520dc2 100%);
            color: white;
        }
    </style>
@endsection

@section('logopantalla')
    <i class="fas fa-file-medical"></i>
@endsection

@section('titulopantalla')
    Ver Resultados
@endsection



@section('contenido')
    <div class="container-fluid">
        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                <div class="col-md-10 text-right"><h4>Estado: {{$examen_orden->estado_examen}}</h4></div>
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
                    

                        @if ( $examen->tiene_referencia =="0")
                            <div class="col-md-6"><h4>PRUEBA</h4></div>
                            <div class="col-md-6"><h4>RESULTADO</div>
                        @else
                            <div class="col-md-3"><h4>PRUEBA</h4></div>
                            <div class="col-md-3"><h4>RESULTADO</div>
                        
                            <div class="col-md-2"><h4>UNIDAD</div>
                            <div class="col-md-4"><h4>VALOR DE REFERENCIA</h4></div>
                            
                        @endif
                       
                              
                    </div>
                    

                    <br>
                    <div class="row justify-content-center">
                        @foreach($resultados as $resultado)
                            @if ($examen->tiene_referencia =="0")
                                <div class="col-md-6"><h5>{{$resultado->caracteristica_examen->nombre_caracteristica_examen}}</h5></div>
                                <div class="col-md-6"><h5>{!!$resultado->valor!!}</h5></div> 
                            @else
                                <div class="col-md-3"><h5>{{$resultado->caracteristica_examen->nombre_caracteristica_examen}}</h5></div>
                                <div class="col-md-3"><h5>{!!$resultado->valor!!}</h5></div> 
                            
                                <div class="col-md-2"><h5>{{$resultado->caracteristica_examen->unidad_caracteristica_examen}}</h5></div>
                                <div class="col-md-4"><h5>{!!$resultado->caracteristica_examen->valor_referencia_caracteristica_examen!!}</h5></div>
                            @endif
                           
                            
                        @endforeach
                    </div> 

                     <br>
                     @if ($examen_orden->datos != '')
                     <div class="row ">
                     <div class="col-md-2"><p>Observaciones:</p></div>
                     <div class="col-md-9"><p>{!!$examen_orden->datos!!}</p></div>
                     </div>
                     @endif
                    
                    <div class="col-md-12"><p>{!!$examen->detalle_examen!!}</p></div>
                    <br>
                    <br>
                    <div class="row justify-content-around">                        

                        <div class="col-3">
                            <a href="{{route('ordenLaboratorio.examenes',['id' =>$orden->id])}}" class="btn btn-secondary btn-lg" id="botoncrear">Atras</a>
                        </div>
                    
                    </div>
   
                        
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
    $(document).ready(function() {
        // Función para imprimir resultados
        window.imprimirResultados = function() {
            window.print();
        };
    });
</script>
@endsection
