@extends('plantillas.plantilla')

@section('titulo')
   Actualizar Examen
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('style.css')}}">
@endsection
@section('logopantalla')
    <i class="fas fa-file-alt"></i>
@endsection
@section('titulopantalla')
    Examen
@endsection

@section('opcionmenu')
<li class="nav-item">
    <a id="medicoa" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opcionesmedico" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-user-md"></i>
      <span>Examenes</span>
    </a>
    <div id="opcionesmedico" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Opciones Medico:</h6>
        <a class="collapse-item" href="{{ route('medico.crear') }}">Insertar medico</a>
        <a class="collapse-item" href="register.html">Register</a>
        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
      </div>
    </div>
  </li>
@endsection

@section('contenido')
  <div class="text-center">  
    <h1>Actualizar Examen</h1>
    <h4>Paso 2: Marque o desmarque las casillas con las caracteristicas del examen</h4>
  </div>
  <div id="cardcrear" class="card col-lg-11">
    <div class="card-body">

        

      <!--muestro el error-->
      @error('status')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>

        <script>
            $(".alert").alert();

        </script>
      @enderror
      <!-- fin del error-->
        
      <form action="{{route ('examen.save2')}}" method="POST" role="form" autocomplete="off">  
        @csrf  
        <div class="row">  
          @foreach($caracteristicas_examen as $caracteristica_examen)
            
              @if(in_array($caracteristica_examen->id, $lista_caracteristicas))                    
                <div class="col-md-4">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="caracteristicas_id[]" id="" value="{{$caracteristica_examen->id}}" checked>
                      <h6>{{$caracteristica_examen->nombre_caracteristica_examen}}</h6>
                    </label>
                  </div>
                </div>
              @else

                <div class="col-md-4">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="caracteristicas_id[]" id="" value="{{$caracteristica_examen->id}}" >
                      <h6>{{$caracteristica_examen->nombre_caracteristica_examen}}</h6>
                    </label>
                  </div>
                </div>

              @endif
              
          @endforeach
            
            
        </div>  
        <br>
        <br>  
                        
        <div class="row justify-content-around" >
          <div class="col-4 ">
            <a href="{{ route('examen.index') }}" class="btn btn-secondary btn-lg" role="button" aria-pressed="true">Cancelar</a>
            
          </div>
          <div class="col-4 ">
            <a href="{{ route('examen.update2',['id'=>$id_examen]) }}" class="btn btn-secondary btn-lg" role="button" aria-pressed="true">Atras</a>
            
          </div>
          <input type="hidden" name="txtid" id="inputtxtid" class="form-control" value="{{$id_examen}}">
          <div class="col-4">              
            <button type="submit" class="btn btn-primary btn-lg">Siguiente</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('footer')
    @include('plantillas.footer')
@section('contenidofooter')

@show
@endsection
