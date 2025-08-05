@error('status')
    <div class="alert alert-success alert-dismissable" style="width: 120%; margin-left:-25%; min-height: 50px; display: flex; align-items: center;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">&times;</button>
        <i class="zmdi zmdi-check" style="margin-right: 15px; font-size: 18px;"></i>
        <p style="margin: 0; flex: 1; padding-right: 40px;">{{ $message }}</p> 
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