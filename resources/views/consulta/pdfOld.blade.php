<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
   <style>
    @page {
      size: 148.5mm 210mm; /* A5 */
      margin: 0;
    }

    #nRegistro{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        font-size:18px;
        color: red;
    }

    #fila{
        font-family: Arial, Helvetica, sans-serif;        
        font-size:18px;
        color: black;
    }

    body {
      margin: 0;
      padding: 0;
      background-image: url('img/MembreteRecetaOld.png');
      background-size:95%; /* O "contain", depende de lo que quieras */
      background-repeat: no-repeat;
      background-position: center center;
    }

    .pagina {
      width: 148.5mm;
      height: 210mm;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: sans-serif;
    }
  </style>
  <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    @foreach ($grupos as $numero => $recetas)
        <div class="pagina">
            <div>    
            <p id="nRegistro" style="padding-top: 122px; padding-left: 428px;">N° {{$numero}}</p>
            </div>
            <div>
                <p style="margin-top: -8px; padding-left: 160px;">{{$consulta->paciente->nombre_paciente}} {{$consulta->paciente->apellido_paciente}}</p>
            </div>
            <div>
                <p style="margin-top: -18px; padding-left: 160px;">{{$consulta->paciente->identificacion_paciente}} </p>
            </div>
            <div>
                <p style="margin-top: -11px; padding-left: 160px;">{{$consulta->fecha_consulta}} </p>
            </div>

            <div style="margin-top: 50px; padding-left: 100px;">
                @foreach ($recetas as $key => $receta)
                    <p  id="fila" style="margin-top: 20px; padding-left:0px;">{{$key+1}}. {{$receta->medicamento}}  #{{$receta->cantidad}} </p>
                    <p   style="margin-top: -20px; padding-left:50px;">{{$receta->dosis}} </p>
                    <p   style="margin-top: -20px; padding-left:20px;">Sig. {{$receta->tratamiento}} </p>
                @endforeach
                
            </div>
            <table style="width: 10%; margin-top: 60px; margin-left: 50px; ">
                <tr>
                    <td style="text-align: left"?>
                        @if($firma)
                            <img src="img/firmas/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                        @endif
                        <td style="text-align: right" >
                            @if($sello)
                                <img src="img/sellos/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                            @endif
                        </td>
                    </tr>
            </table> 

        </div>
    @endforeach
</body>
</html>