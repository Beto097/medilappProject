const lista = document.getElementById('lista');


Sortable.create(lista,{
    animation: 150,
    ghostClass: 'blue-background-class',
    dragClass: 'drag',
    store: {
        set: (sorteable)=> {
            const orden = sorteable.toArray();
                    
            document.getElementById('inputOrden').value =orden; 
        }
    }


});
