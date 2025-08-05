<script>


function agregarFila() {
    console.log('agregarfila');
        var nuevaFila = document.querySelector(".filaReceta").cloneNode(true); // Clona la primera fila
        
        // Limpiar los valores de los inputs
        nuevaFila.querySelectorAll("input").forEach(function(input) {
            input.value = ""; // Borra el contenido de cada input
        });

        // Crear botón de eliminar en la nueva fila
        var botonEliminar = document.createElement("button");
        botonEliminar.type = "button";
        botonEliminar.className = "btn btn-danger";
        botonEliminar.innerHTML = '<i class="fa fa-trash"></i>';
        botonEliminar.onclick = function () {
            this.parentElement.parentElement.remove(); // Elimina la fila al hacer clic
        };

        // Agregar el botón de eliminar al div correspondiente
        nuevaFila.querySelector(".form-group:last-child").appendChild(botonEliminar);

        // Agregar la nueva fila al contenedor
        document.getElementById("contenedorReceta").appendChild(nuevaFila);
    }
</script>
<script>
    let txtEliminarId =[];
    function agregarFila2() {
    
        var nuevaFila = document.querySelector(".filaReceta").cloneNode(true);
        
        nuevaFila.querySelectorAll("input").forEach(function(input) {
            input.value = ""; // Limpia los campos
        });

        nuevaFila.removeAttribute("data-id"); // Elimina el atributo de ID si es una nueva fila
        nuevaFila.querySelector(".eliminarFila").setAttribute("onclick", "this.parentElement.parentElement.remove()"); // Permite eliminar filas nuevas

        document.getElementById("contenedorReceta").appendChild(nuevaFila);
    }

    function eliminarFila2(id,element) {


        txtEliminarId.push(id)
      
        document.getElementById('txtEliminarId').value=JSON.stringify(txtEliminarId);
        
        element.parentElement.parentElement.remove();
               
    }

</script>


