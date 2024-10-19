<!doctype html>
<html lang="en">
  <head>
    <title>Resultado</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- CSS only -->
    <style>

        #clinica{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size:25px;
            
        }
        #titulo{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size:18px;
            margin-bottom: -5px;
            
        }

        #titulo_orden{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size:18px;
            margin-bottom: 10px;
            
        }

       
        #subClinica{
            margin-top: -20px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:16px;
            line-height: 1;
            
        }
        #texto{
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:16px;
            margin-bottom: -4px;
            margin-top: 0px;
            line-height: 1.5;
            
        }
        #texto-2{
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:15px;
            margin-bottom: -2px;
            line-height: 1.8;
            margin-top: 4px;
            
        }
        #texto-3{
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:15px;
            margin-bottom: -2px;
            line-height: 1.8;
            margin-top: 50px;
            
        }
        #texto-4{
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:15px;
            margin-bottom: -2px;
            line-height: 1.8;
            margin-top: 10px;
            
        }
        #texto-5{
            font-family: Arial, Helvetica, sans-serif;
            font-weight:lighter;
            font-size:10px !important;
            text-align: center;
            margin-bottom: -2px;
            line-height: 1.8;
            margin-top: 10px;
            
        }
     
       
    </style>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  </head>
  <body background="images/ValmarHojaMembretada2.png">

    <table style="width: 100%";>
        <tr>
            <td style="text-align: left"?>
                <span>Tu logo Aqui</span>
                <td style="text-align: right" width="550px">
                    
                    <p  id="clinica" style="text-align: center" >
                        Medilapp S.A.
                    </p>
                    
                    <p id="subClinica" style="text-align: center">
                        Descripcion
                    </p>
                </td>
            </td>
        </tr>
    </table>
    
    
    <p id="titulo_orden" style="text-align:center"?>
        Orden de Laboratorio Nº: {{$orden->id}}
    </p>
   

    <table style="width: 100%";>
        <tr>
            <td style="text-align: left"?>
                <p id="texto">
                    Paciente: {{$orden->paciente->nombre_paciente}} {{$orden->paciente->apellido_paciente}}
                </p>
                <td style="text-align: right" >
                    <p id="texto">
                        Identificacion: {{$orden->paciente->identificacion_paciente}}
                    </p>
                </td>
            </td>
        </tr>
    </table>
    <table style="width: 100%";>
        <tr>
            <td style="text-align: left"?>
                <p id="texto">
                    Sexo: 
                    @if($orden->paciente->sexo_paciente == 'm')
                        Masculino
                    @else
                        Femenino
                    @endif
                </p>
                <td style="text-align: right" >
                    <p id="texto">
                        Edad: {{$edad_paciente}} años
                    </p>
                </td>
            </tr>
    </table>
    <table style="width: 100%";>
        <tr>
            <td style="text-align: left"?>
                <p id="texto">
                    Medico: {{$orden->medico->nombre_medico}}-{{$orden->medico->numero_registro}}
                </p>
                <td style="text-align: right" >
                    <p id="texto">
                        Fecha: {{$orden->fecha_orden}}
                    </p>
                </td>
            </tr>
    </table>            
    
      
   
    <br>
    <div class="container text-center">
        <p id="titulo">INFORME GENERAL DE LABORATORIO</p>
    </div>
        
     <div class="container text-center">
        <p id="titulo">

            @if(isset($tipo_examen))
                {{$tipo_examen->nombre_tipo_examen}}            
                
            @else
                {{$examen->tipo_examen->nombre_tipo_examen}}    
            @endif
        </p>
        
    </div>
    
    
      <br>              
    <table class="table justify-content-center">
        
            
       
        
        <tbody>
            <tr>
                @if ($conteo =='0')
                    <td>
                        <p id="titulo">PRUEBA</p></td>
                    <td>
                        <div class="container text-center">
                            <p id="titulo">RESULTADO</p>
                        </div>
                    </td>
                    <td>
                        <div class="container text-center">
                            <p id="titulo">UNIDAD</p>
                        </div>
                    </td>
                    <td>
                        <div class="container text-center" style="width: 200px;">
                            <p id="titulo">VALOR REFERENCIA</p>
                        </div>
                    </td>
                @else
                    <td><p id="titulo">PRUEBA</p></td>
                    <td>
                        <div class="container text-center">
                            <p id="titulo">RESULTADO</p>
                        </div>
                    </td>
                @endif
                
            </tr>
            <?php
                $pagina=1;
                $altura = 0;
            ?>
            @foreach($resultados as $resultado)
                <?php
                    $var2 = (substr_count($resultado->caracteristica_examen->valor_referencia_caracteristica_examen,"<br />")+1)*28;
                    
                    $altura = $altura+$var2;
                ?>               
                
                <tr>
                    @if ($conteo =='0')
                        <td scope="row">
                            <p id="texto-2">
                              {{$resultado->caracteristica_examen->nombre_caracteristica_examen}}
                            </p>
                        </td>
                        <td>
                            <div class="container text-center">
                                <p id="texto-2">
                                    {!!$resultado->valor!!}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="container text-center">
                                <p id="texto-2">
                                    {{$resultado->caracteristica_examen->unidad_caracteristica_examen}}
                                </p>
                            </div>
                        </td>
                        <td 
                            @if(substr_count($resultado->caracteristica_examen->valor_referencia_caracteristica_examen,"<br />")>0) 
                                

                                <?php 
                                    $var1 ='style="height:';                                   
                                    $var3 = 'px";';
                                    $completo = $var1.$var2.$var3;
                                    echo $completo;
                                ?>                           
                            
                            
                                
                            @endif>
                            <div class="container text-center">
                                <p id="texto-2">
                                    {!!$resultado->caracteristica_examen->valor_referencia_caracteristica_examen!!}
                                </p>
                            </div>
                        </td>
                        @if ($altura>545)
                            <tr>
                                <td>

                                </td>
                                <td >
                                       
                                </td>
                                <td>

                                </td>
                                <td>
                                <div style="text-align: right;">
                                        <p id="texto-3">pagina {{$pagina}}</p>
                                    </div> 
                                </td>
                                
                                <?php
                                    $pagina = $pagina+1;
                                    $altura = 0;
                                ?>

                            </tr>
                            
                            <tr>
                                <td style="text-align: left">
                                    <img src="images/fondo.png" width="200"/>                            
                                </td>
                                <td>
                                    <p id="texto-5" style="text-align:left"?>
                                        Orden de Laboratorio Nº: {{$orden->id}}
                                    </p>

                                </td>
                                <td>

                                </td>
                                
                                <td>
                                    <div style="text-align: right">
                                        <p id="texto-4">pagina {{$pagina}}</p>
                                    </div> 
                                </td>
                                
                                <?php
                                    $pagina = $pagina+1;
                                    
                                ?>

                            </tr>
                            
                        @endif
                    @else
                        <td scope="row">
                            <p id="texto-2">
                                {{$resultado->caracteristica_examen->nombre_caracteristica_examen}}
                            </p>
                        </td>
                        <td>
                            <div class="container text-center">
                                <p id="texto-2">                                
                                    {!!$resultado->valor!!}
                                </p>

                            </div>
                        </td>
                    @endif
                   
                </tr>
               
                
            @endforeach
        </tbody>
    </table> 
    <br>
    <table style="width: 100%";>
        <tr>
            <td style="text-align: left"?>
                <p id="texto">{!!$examen->detalle_examen!!}</p>
                <td style="text-align: right" >
                    
                </td>
            </tr>
    </table>
    
    <table style="width: 10%";>
        <tr>
            <td style="text-align: left"?>
                Firma Aqui
                <td style="text-align: right" >
                    
                </td>
            </tr>
    </table> 
                
            
        
        
  


      



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>








