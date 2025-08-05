<script>
    var app_url ='{{env('APP_URL')}}'; 

    function validarCedula(){           
      const url = app_url+'/consultar/'+document.getElementById('txtCedula').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {
            let cedula=respuesta.cedula ;
            let consulta =respuesta.consulta;
            if (cedula != document.getElementById('txtCedula').value ){
                document.getElementById('AlertaCedula2').innerHTML ="esta cedula no existe debe crear el paciente";                    
                document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-error";                    
                document.getElementById("divBtn").classList.add("hidden"); 
               
               
            }
            else{
                
                document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-success"; 
                if(!consulta){
                    
                    document.getElementById('AlertaCedula2').innerHTML ="";
                    document.getElementById("divBtn").classList.remove("hidden");
                } else{
                    document.getElementById('AlertaCedula2').innerHTML ="Este paciente ya tiene una consulta abierta";
                    document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-error";     
                    document.getElementById("divBtn").classList.add("hidden");
                }              
                


                
                let edad = respuesta.edad;
                let contenido = document.getElementById("contenidoMenor");
           
                if (edad >= 18) {
                    
                    contenido.classList.add("hidden");
                   
                } else {
                   
                    contenido.classList.remove("disabled-div", "hidden");
                }

                
            }                
        });
      
    }

</script>

<style>
    .disabled-div {
        pointer-events: none; /* Evita clics e interacción */
        opacity: 0.5; /* Lo hace visualmente tenue */
    }
    .hidden {
        display: none; /* Oculta el div completamente */
    }
</style>