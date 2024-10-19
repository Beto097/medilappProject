@extends('plantilla.plantilla')

@section('titulo')
   Resultado de Examen
@endsection





@section('contenido')
    				
    <div class="row">
        
        <br> 
        <div class="col-lg-10 col-md-offset-1">
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
        
      

        @include('plantilla.errores')
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h4 class="panel-title txt-dark">{{$examen->nombre_examen}}</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
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
                            <div class="col-md-12"><p>{!!$examen->detalle_examen!!}</p></div>
                            <br>
                            <br>
                            <div class="row">                        
        
                                <div class="col-lg-3 col-lg-offset-3">
                                    <a href="{{route('ordenLaboratorio.examenes',['id' =>$orden->id])}}" class="btn btn-danger btn-lg" id="botoncrear">Atras</a>
                                </div>
                            
                            </div>
           
                                
                        </div>
                    </div>
                </div>
            </div>	
        </div> 
    </div>
   
@endsection

