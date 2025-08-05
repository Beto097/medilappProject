<script>
    var app_url ='{{env('APP_URL')}}'; 
    function validar(){           
      const url = app_url+'/consultar/'+document.getElementById('txtCedula').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let cedula=respuesta.cedula ;
            if (cedula == document.getElementById('txtCedula').value ){
                document.getElementById('AlertaCedula').innerHTML =respuesta.nombre;                    
                document.getElementById("cedulaDiv").classList.add("has-success");  
                document.getElementById("cedulaDiv").classList.remove("has-error");                 
                document.getElementById("btnCrearPaciente").disabled = true;
                document.getElementById("txtCedula3").value = cedula;
                document.getElementById("cedulaDiv3").classList.remove("has-success");  
                document.getElementById("cedulaDiv3").classList.add("has-error");   
                if(document.getElementById("txtCedula").className == "form-control is-valid" && document.getElementById("txtRegistro").className == "form-control is-valid"){
                    document.getElementById("botoncrear").disabled =false;
                    document.getElementById("crearOrden").checked =true;
                }else{
                    document.getElementById("botoncrear").disabled =true;
                    document.getElementById("crearOrden").checked =false;
                }
            }
            else{
                document.getElementById('AlertaCedula').innerHTML ="esta cedula no existe debe crear el paciente"
                document.getElementById("cedulaDiv").classList.remove("has-success");  
                document.getElementById("cedulaDiv").classList.add("has-error");                  
                document.getElementById("btnCrearPaciente").disabled = false;
                document.getElementById("txtCedula3").value = document.getElementById('txtCedula').value;
                document.getElementById("cedulaDiv3").classList.add("has-success");  
                document.getElementById("cedulaDiv3").classList.remove("has-error");
                
            }
            if(document.getElementById("cedulaDiv").className == "form-group col-md-7 col-sm-12 col-xs-12 has-success" && document.getElementById("registroDiv").className == "form-group col-md-7 col-sm-12 col-xs-12 has-success"){
                document.getElementById("botoncrear").disabled =false;
            }else{
                document.getElementById("botoncrear").disabled =true;
                document.getElementById("crearOrden").checked =false;
            }
        });
      
    }
    function validar2(){           
        const cedula = document.getElementById('txtCedula2').value.trim();
        const url = `${app_url}/consultar/${cedula}`;

        fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {
            if (respuesta.cedula === cedula) {
                document.getElementById('AlertaCedula2').innerHTML ="esta cedula ya existe...";                    
                document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-error";                    
                document.getElementById("btnCrearModal").disabled = true; 
                document.getElementById("txtCedula4").className = "form-control is-invalid";    
            }else{

                document.getElementById('AlertaCedula2').innerHTML =""
                document.getElementById("cedulaDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-success";                   
                document.getElementById("btnCrearModal").disabled = false;
                document.getElementById("txtCedula4").className = "form-control is-valid"; 
            }
        })
        .catch(error => {
            // Manejo de errores si el servidor responde con error (400, 500, etc.)
            console.error("Hubo un error en la consulta:", error);
        });       
    
      
    }
    function validar3(){           
      const url = app_url+'/consultar/'+document.getElementById('txtCedula3').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let cedula=respuesta.cedula ;
            if (cedula == document.getElementById('txtCedula3').value ){
                document.getElementById('AlertaCedula3').innerHTML ="esta cedula ya existe...";                    
                document.getElementById("cedulaDiv3").classList.remove("has-success");  
                document.getElementById("cedulaDiv3").classList.add("has-error");                     
                document.getElementById("btnCrearModal2").disabled = true; 
                                  
               
            }
            else{
                document.getElementById('AlertaCedula3').innerHTML =""
                document.getElementById("cedulaDiv3").classList.add("has-success");  
                document.getElementById("cedulaDiv3").classList.remove("has-error");                     
                document.getElementById("btnCrearModal2").disabled = false;
                 
                
            }                
        });
      
    }
    function validar4(){           
      const url = app_url+'/consultar/'+document.getElementById('txtCedula4').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let cedula=respuesta.cedula ;
            if(cedula ==  document.getElementById('txtCedulaOld').value){
                document.getElementById('AlertaCedula4').innerHTML =""
                document.getElementById("txtCedula4").className = "form-control is-valid";                   
                document.getElementById("btnEditPacienteModal").disabled = false;

            }
            else if (cedula == document.getElementById('txtCedula4').value ){
                document.getElementById('AlertaCedula4').innerHTML ="esta cedula ya existe...";                    
                document.getElementById("txtCedula4").className = "form-control is-invalid";                    
                document.getElementById("btnEditPacienteModal").disabled = true; 
                                    
               
            }
            else{
                document.getElementById('AlertaCedula4').innerHTML =""
                document.getElementById("txtCedula4").className = "form-control is-valid";                   
                document.getElementById("btnEditPacienteModal").disabled = false;
                 
                
            }                
        });
      
    }
    function validarRegistro(){
      const url = app_url+'/consultarRegistro/'+document.getElementById('txtRegistro').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let registro=respuesta.registro ;
            if (registro == document.getElementById('txtRegistro').value ){
                document.getElementById('AlertaRegistro').innerHTML =respuesta.nombre; 
                document.getElementById("registroDiv").classList.add("has-success");  
                document.getElementById("registroDiv").classList.remove("has-error"); 
                document.getElementById('AlertaMedico').innerHTML ="";
                document.getElementById("btnCrearMedico").disabled = true;
                document.getElementById("txtRegistro3").value = registro;
                if(document.getElementById("txtCedula").className == "form-control is-valid"  && document.getElementById("txtRegistro").className == "form-control is-valid"){
                    document.getElementById("botoncrear").disabled =false;
                }else{
                    document.getElementById("botoncrear").disabled =true;
                    document.getElementById("crearOrden").checked =false;
                }
                
            }
            else{
                document.getElementById('AlertaRegistro').innerHTML ="este medico no existe debe crearlo";
                document.getElementById('AlertaMedico').innerHTML ='puede ingresar el "0" sino tiene medico';
                document.getElementById("registroDiv").classList.remove("has-success");  
                document.getElementById("registroDiv").classList.add("has-error"); 
                document.getElementById("btnCrearMedico").disabled = false;
                document.getElementById("txtRegistro2").value = document.getElementById('txtRegistro').value;
                document.getElementById("txtRegistro2").className = "form-control is-valid"; 
            }
            if(document.getElementById("cedulaDiv").className == "form-group col-md-7 col-sm-12 col-xs-12 has-success" && document.getElementById("registroDiv").className == "form-group col-md-7 col-sm-12 col-xs-12 has-success"){
                document.getElementById("botoncrear").disabled =false;
                document.getElementById("crearOrden").checked =true;
            }else{
                document.getElementById("botoncrear").disabled =true;
                document.getElementById("crearOrden").checked =false;
            }
            
        });

        
      
    }
    function validarRegistro2(){
      const url = app_url+'/consultarRegistro/'+document.getElementById('txtRegistro2').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let registro=respuesta.registro ;
            if (registro == document.getElementById('txtRegistro2').value ){
                document.getElementById('AlertaRegistro2').innerHTML ="este registro ya existe...";                    
                document.getElementById("registroDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-error"; 
                document.getElementById('AlertaMedico2').innerHTML ="";
                document.getElementById("btnCrearMedicoModal").disabled = true;
                
            }
            else{
                document.getElementById('AlertaRegistro2').innerHTML ="";                    
                document.getElementById("registroDiv").className = "form-group col-md-6 col-sm-12 col-xs-12 has-success"; 
                document.getElementById('AlertaMedico2').innerHTML ="";
                document.getElementById("btnCrearMedicoModal").disabled = false;
            }
          
            
        });

        
      
    }
    function validarRegistro3(){
      const url = app_url+'/consultarRegistro/'+document.getElementById('txtRegistroModalOrden').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let registro=respuesta.registro ;
            if (registro == document.getElementById('txtRegistroModalOrden').value ){
                document.getElementById('AlertaRegistro3').innerHTML ="este registro ya existe...";                    
                document.getElementById("registroDiv3").classList.remove("has-success");  
                document.getElementById("registroDiv3").classList.add("has-error"); 
                document.getElementById('AlertaMedico3').innerHTML ="";
                document.getElementById("btnCrearMedicoModal").disabled = true;
                
            }
            else{
                document.getElementById('AlertaRegistro3').innerHTML ="";                    
                document.getElementById("registroDiv3").classList.add("has-success");  
                document.getElementById("registroDiv3").classList.remove("has-error"); 
                document.getElementById('AlertaMedico3').innerHTML ="";
                document.getElementById("btnCrearMedicoModal").disabled = false;
            }
          
            
        });

        
      
    }
    function validarRegistro4(){           
      const url = app_url+'/consultar/'+document.getElementById('txtRegistro4').value;
      fetch(url)
        .then(respuesta => respuesta.json() )
        .then(respuesta => {let cedula=respuesta.cedula ;
            if(cedula ==  document.getElementById('txtRegistroOld').value){
                document.getElementById('AlertaRegistro4').innerHTML =""
                document.getElementById("txtRegistro4").className = "form-control is-valid";                   
                document.getElementById("btnEditMedicoModal").disabled = false;

            }
            else if (cedula == document.getElementById('txtRegistro4').value ){
                document.getElementById('AlertaRegistro4').innerHTML ="esta cedula ya existe...";                    
                document.getElementById("txtRegistro4").className = "form-control is-invalid";                    
                document.getElementById("btnEditMedicoModal").disabled = true; 
                                    
               
            }
            else{
                document.getElementById('AlertaRegistro4').innerHTML =""
                document.getElementById("txtRegistro4").className = "form-control is-valid";                   
                document.getElementById("btnEditMedicoeModal").disabled = false;
                 
                
            }                
        });
    }
    function cambiarBoton(){
        
        validar();
        validarRegistro();
        
            
        
    }
    
    function cargaPagina(){
        document.getElementById("botoncrear").disabled =true;
        if(document.getElementById('txtCedula').value!=""){
            validar();
        }
        if(document.getElementById('txtRegistro').value!=""){
            validarRegistro();
        }
        
        
    }

    function listaExterno(){
        if (document.getElementById('esExterno').checked){
            
            document.getElementById('select').hidden = false;
            
        } else {
            document.getElementById('select').hidden = true;
            
        }
    }
</script>