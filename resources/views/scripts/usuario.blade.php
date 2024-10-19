<script>
    var app_url ='{{env('APP_URL')}}'; 
    function userName(){           
      const url = app_url+'/userName/'+document.getElementById('txtUsuario').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let nombre=respuesta.nombre ;
            if (nombre == document.getElementById('txtUsuario').value ){
                document.getElementById('AlertaUsuario').innerHTML ='Este nombre ya existe';                    
                document.getElementById("txtUsuario").className = "form-control is-invalid";                    
                document.getElementById("botoncrear").disabled = true;
                
                
            }
            else{
                document.getElementById('AlertaUsuario').innerHTML ='';                    
                document.getElementById("txtUsuario").className = "form-control is-valid";                    
                document.getElementById("botoncrear").disabled = false;
                    
                
            }
           
        });
      
    }
    function validarEmail(){           
      const url = app_url+'/email/jahazieldesalas@hotmail.com';
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let email=respuesta.email ;
            if (email =="jahazieldesalas@hotmail.com"){
                document.getElementById('AlertaEmail').innerHTML ='Este correo ya existe';                    
                document.getElementById("txtEmail").className = "form-control is-invalid";                    
                document.getElementById("botoncrear").disabled = true;
                
                
            }
            else{
                document.getElementById('AlertaEmail').innerHTML ='';                    
                document.getElementById("txtEmail").className = "form-control is-valid";                    
                document.getElementById("botoncrear").disabled = false;
                    
                
            }
           
        });
      
    }

    
   
 
</script>