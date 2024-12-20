@extends('users.layouts.auth')

@section('content')
    <p class="login-box-msg">
        You are only one step a way from your new password, recover your password now.
    </p>
    <form id="resetPasswordForm" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="input-group mb-3">
            <input type="email" name="email" id="resetPasswordEmail" class="form-control"
                placeholder="Enter Email Address">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" id="resetPasswordPassword" class="form-control"
                placeholder="Enter Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="resetPasswordPasswordConfirmation" class="form-control"
                placeholder="Confirm Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="resetPasswordSubmitBtn" class="btn btn-primary btn-block">
                    Change password
                </button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mt-3 mb-1">
        <a href="{{ route('users.login') }}">Login</a>
    </p>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#resetPasswordForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var path = '{{ route('users.reset.password.store') }}';
            $.ajax({
                url:path,
                type:'POST',
                data:formData,
                contentType:false,
                processData:false,
                beforeSend:function(){
                    $('#resetPasswordSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                    $('#resetPasswordSubmitBtn').attr('disabled',true);
                },
                complete:function(){
                    $('#resetPasswordSubmitBtn').html('Change password');
                    $('#resetPasswordSubmitBtn').attr('disabled',false);
                },
                success:function(data){
                    if(data['status']){
                        toastr.success(data['message']);
                        setTimeout(function(){
                            window.location.href = '{{ route('users.login') }}';
                        },2000);
                    }else{
                        console.log(data);
                    }
                }
            });
        });
    });
</script>

@endsection
