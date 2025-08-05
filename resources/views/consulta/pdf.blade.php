<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
   <style>
    @page {
        size: 280mm 432mm; /* Half Letter in mm */
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
        font-size:28px;
        color: black;
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
    }

    body {
      margin: 0;
      padding: 0;
      background-image: url('{{ public_path('img/MembreteReceta.png') }}');
      background-size:contain;
      background-repeat: no-repeat;
      background-position: center center;
    }

    .pagina {
      width: 240mm;
      height: 400mm;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: sans-serif;
    }
  </style>
  <!-- CSS only -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->
</head>
<body>
    @foreach ($grupos as $numero => $recetas)
        <div class="pagina">
            <div>    
            <p id="nRegistro" style="padding-top: 90px; padding-left: 700px;">N° {{$numero}}</p>
            </div>
            <div>
                <p id="head" style="margin-top: 218px; padding-left: 240px;">{{$consulta->paciente->nombre_paciente}} {{$consulta->paciente->apellido_paciente}}</p>
            </div>
            <div>
                <p id="head" style="margin-top: -3px; padding-left: 350px;">
                    {{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento_paciente)->format('d-m-Y') }}
                </p>
            </div>
            <div>
                <p id="head" style="margin-top: -43px; padding-left: 730px;">
                    {{ \Carbon\Carbon::parse($consulta->paciente->fecha_nacimiento_paciente)->age }}
                </p>
            </div>
            <div>
                <p id="head" style="margin-top: 3px; padding-left: 210px;">{{$consulta->paciente->identificacion_paciente}} </p>
            </div>
            <div>
                <p id="head" style="margin-top: -135px; padding-left: 750px;">{{$consulta->fecha_consulta}} </p>
            </div>
            <div>
                <p id="bodyMed" style="margin-top: 125px; padding-left: 190px;">{!! $consulta->diagnostico ? e($consulta->diagnostico) : '&nbsp;' !!} </p>
            </div>
            <div style="margin-top: 120px; padding-left: 180px;">
                @foreach ($recetas as $key => $receta)
                    <p  id="fila" style="margin-top: 20px; padding-left:0px;">{{$key+1}}. {{$receta->medicamento}}  #{{$receta->cantidad}} </p>
                    <p  id="bodyMed" style="margin-top: -20px; padding-left:50px;">{{$receta->dosis}} </p>
                    <p  id="bodyMed" style="margin-top: -20px; padding-left:20px;">Sig. {{$receta->tratamiento}} </p>
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


