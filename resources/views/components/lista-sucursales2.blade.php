
<div class="col-lg-7"><label for="">Seleccione una Sucursal</label> </div>                                                                          
<div class="col-lg-5">
    <select class="form-control" name="selectSucursal" id="">
        <option value='0' selected>Sin Sucursal</option>
        @foreach($sucursales as $sucursal)                                                
            @if(isset(Auth::user()->sucursal))
                @if($sucursal->id == Auth::user()->sucursal->id)
                    <option value="{{$sucursal->id}}" selected>{{$sucursal->nombre_sucursal}} </option>
                @else
                    <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}}</option>
                @endif
            @else  
                <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}}</option>
               

            @endif
                
               
        
        @endforeach
        
        
    </select>
</div>
