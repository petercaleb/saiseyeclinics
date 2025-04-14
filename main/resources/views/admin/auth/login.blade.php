@extends('admin.layouts.auth')

@section('content')
    <p class="login-box-msg">
        Sign in to start your session
    </p>

    <form id="loginForm" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" id="loginEmail" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button id="loginSubmitBtn" type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mb-1">
        <a href="{{ route('admin.forget.password') }}">
            I forgot my password
        </a>
    </p>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                var path = '{{ route('admin.login') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Sign In');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            setTimeout(function() {
                                window.location.href =
                                    '{{ route('admin.organization.index') }}';
                            }, 2000);
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
