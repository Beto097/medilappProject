@error('status')
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="zmdi zmdi-check pr-15 pull-left"></i><p class="pull-left">{{ $message }}</p> 
        <div class="clearfix"></div>
    </div>    

    <script>
        $(".alert").alert();

    </script>
@enderror
@error('danger')
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">{{$message}}</p>
        <div class="clearfix"></div>
    </div>

    <script>
        $(".alert").alert();

    </script>
@enderror