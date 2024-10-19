<div id="editarRolModal{{$fila->id}}"   class="modal fade" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-valmar">

                <h5 class="modal-title"><span class="font-weight-bold text-white">Editar Rol</span></h5>

                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body text-left" >

                <form action="{{route('rol.save')}}" method="POST" role="form" autocomplete="off">  
                    @csrf      
                    <div class="form-group">
                        <label class="text-rigth" for="">Nombre</label>
                        <input type="text" class="form-control" id="" placeholder="Ejemplo: Recepcionista" name="txtNombre" required value="{{$fila->nombre_rol}}">
                    </div>
                    <input type="hidden" name="txtId" id="input" class="form-control" value="{{$fila->id}}">
                
                
                    <br>
                    <br>
                
                    <div class="row justify-content-around"> 
                        <div class="col-8">

                        </div>
                        <div class="col-4"> 
                            <input type="hidden" name="txtId" value="{{$fila->id}}">
                            <button type="submit" id="botoncrear" class="btn btn-info btn-lg"> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
