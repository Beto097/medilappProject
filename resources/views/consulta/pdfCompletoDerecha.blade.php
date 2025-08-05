<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
   <style>
    @page {
        size: 22in 17in; /* Letter size landscape (horizontal) */
        margin: 1mm;
    }

    #nRegistro{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        font-size:35px;
        color: red;
    }

    #fila{
        font-family: Arial, Helvetica, sans-serif;        
        font-size:25px;
        color: black;
        width: 60%;
    }

    #head{
        font-family: Helvetica, sans-serif;        
        font-size:20px;
        color: black;
    }

    #bodyMed{
        font-family: Helvetica, sans-serif;        
        font-size:25px;
        color: black;
        width: 75%;
    }

    body {
      margin: 0;
      padding: 0;
      background-image: url('{{ public_path('img/MembreteReceta.png') }}');
      background-size: 50% auto; /* Ajustar imagen a la mitad derecha */
      background-repeat: no-repeat;
      background-position: right center; /* Posicionar a la derecha */
    }

    .pagina {
      width: 100%; /* Usar todo el ancho */
      height: 100vh;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      font-family: sans-serif;
      position: relative;
    }

    .contenido-derecho {
      width: 50%; /* Solo la mitad derecha */
      height: 100%;
      position: relative;
      margin-left: 50%; /* Empujar hacia la derecha */
    }
  </style>
  <!-- CSS only -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->
</head>
<body>
    @foreach ($grupos as $numero => $recetas)
        <div class="pagina">
            <div class="contenido-derecho">
                <div>    
                    <p id="nRegistro" style="padding-top: 105px; padding-left: 750px;">N° {{$numero}}</p>
                </div>
                <div>
                    <p id="head" style="margin-top: 201px; padding-left: 226px;">{{$consulta->paciente->nombre_paciente}} {{$consulta->paciente->apellido_paciente}}</p>
                </div>
                <div>
                    <p id="head" style="margin-top: -43px; padding-left: 750px;">{{\Carbon\Carbon::parse($consulta->fecha_consulta)->format('d-m-Y') }} </p>
                </div>
                <div>
                    <p id="head" style="margin-top: -3px; padding-left: 350px;">
                        {{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento_paciente)->format('d-m-Y') }}
                    </p>
                </div>
                <div>
                    <p id="head" style="margin-top: -43px; padding-left: 750px;">
                        {{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento_paciente)->age }}
                    </p>
                </div>
                <div>
                    <p id="head" style="margin-top: 3px; padding-left: 205px;">{{$consulta->paciente->identificacion_paciente}} </p>
                </div>
                <div>
                    <p id="fila" style="margin-top: 125px; padding-left: 205px;">{!! $consulta->diagnostico ? e($consulta->diagnostico) : '&nbsp;' !!}</p>
                </div>
                <div style="margin-top: 115px; padding-left: 205px;">
                    @foreach ($recetas as $key => $receta)
                        <p  id="fila" style="margin-top: 20px; padding-left:-5px;">{{$key+1}}. {{$receta->medicamento}}  #{{$receta->cantidad}} </p>
                        <p  id="bodyMed" style="margin-top: -20px; padding-left:25px;">{{$receta->dosis}} </p>
                        <p  id="bodyMed" style="margin-top: -20px; padding-left:10px;">Sig. {{$receta->tratamiento}} </p>
                    @endforeach
                </div>
                <table style="width: 80%; margin-top: 30px; margin-left: -25px;">
                    <tr>
                        <td style="text-align: left">
                            @if($firma)
                                <img src="img/firmas/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                            @endif
                        </td>
                        <td style="text-align: right">
                            @if($sello)
                                <img src="img/sellos/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                            @endif
                        </td>
                    </tr>
                </table> 
            </div>
        </div>
    @endforeach
</body>
</html>


