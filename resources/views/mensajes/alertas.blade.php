@error('status')
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
        role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
        <i class="mdi mdi-check-circle me-2"></i>{{$message}}
    </div>
@enderror

@error('danger')

    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-0"
        role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
        <i class="mdi mdi-close-circle me-2"></i>{{$message}}        
    </div>
    
@enderror

@error('passwordRed')

    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-0"
        role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
        <i class="mdi mdi-close-circle me-2"></i>{{$message}}        
    </div>
    
@enderror

@error('passwordGreen')
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
        role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
        <i class="mdi mdi-check-circle me-2"></i>{{$message}}
    </div>
@enderror