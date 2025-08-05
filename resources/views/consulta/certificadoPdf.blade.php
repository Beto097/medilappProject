<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
   <style>
    @page {
      size:  210mm 148.5mm; /* A5 */
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
      background-image: url('img/Certificado.png');
      background-size:98%; /* O "contain", depende de lo que quieras */
      background-repeat: no-repeat;
      background-position: center center;
    }

    .pagina {
      width: 210mm;
      height: 148.5mm;
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
    
        <div class="pagina">
            <div>    
                <p id="nRegistro" style="padding-top: 175px; padding-left: 520px;">N° {{$numero}}</p>
            </div>
            <div>
                <p style="position:absolute; margin-top: 22px; padding-left: 145px;">{{$consulta->paciente->nombre_paciente}} {{$consulta->paciente->apellido_paciente}}</p> <p style="position:absolute; margin-top: 22px; padding-left: 525px;">{{$consulta->paciente->identificacion_paciente}} </p>
            </div>
            
            <div style="position:absolute; text-align: left width: 10%; margin-top: 115px; margin-left: 130px;">
                @if($firma)
                    <img src="img/firmas/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                @endif
            </div>
            <div style="position:absolute; margin-top: 115px; margin-left: 330px;" >
                @if($sello)
                    <img src="img/sellos/{{$consulta->doctor->nombre_usuario}}.PNG" width="150"/>
                @endif
            </div>
            <div>
                <p style="position:absolute ; margin-top: 200px; padding-left: 530px;">{{\Carbon\Carbon::parse($fecha)->format('d-m-Y')}} </p>
            </div>
                    
           

        </div>
   
</body>
</html>


