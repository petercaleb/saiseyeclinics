@extends('admin.layouts.auth')

@section('content')
    <p class="login-box-msg">Register a new membership</p>

    <form id="registerForm">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="registerFirstName" name="first_name" placeholder="First Name">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="registerLastName" name="last_name" placeholder="Last Name">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="registerPhone" name="phone" placeholder="Phone Number">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-phone"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="email" name="email" id="registerEmail" class="form-control" placeholder="Email Address">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="registerUsername" name="username" placeholder="Username">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" id="registerPassword" class="form-control" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="confirm_password" id="registerConfirmPassword" class="form-control" placeholder="Retype password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                        I agree to the <a href="#">terms</a>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mb-1">
        <a href="{{ route('admin.login') }}" class="text-center">
            I already have a membership
        </a>
    </p>
@endsection

@section('scripts')

<script>
    $(function() {
        $('#registerForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var path = '{{ route('admin.register') }}'
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    form.find('button[type=submit]').html('<i class="fa fa-spinner fa-spin"></i>');
                    form.find('button[type=submit]').attr('disabled', true);
                },
                complete:function(){
                    form.find('button[type=submit]').html('Register');
                    form.find('button[type=submit]').attr('disabled', false);
                },
                success: function(response, xhr) {
                    if(response['status']){
                        toastr.success(response['message']);
                        setTimeout(function(){
                            window.location.href = '{{ route('admin.organization.index') }}';
                        }, 2000);
                    }else{
                        console.log(data);
                    }
                },
                error: function(data){
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    }
            });
        });
    });
</script>


@endsection
