@extends('users.layouts.auth')

@section('content')
    <p class="login-box-msg">
        You forgot your password? Here you can easily retrieve a new password.
    </p>

    <form id="forgotPasswordForm" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" id="forgotPasswordEmail" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="forgotPasswordSubmitBtn" class="btn btn-primary btn-block">Request new
                    password</button>
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

            $('#forgotPasswordForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.forgot.password') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#forgotPasswordSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#forgotPasswordSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#forgotPasswordSubmitBtn').html('Request new password');
                        $('#forgotPasswordSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#forgotPasswordForm')[0].reset();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

        });
    </script>
@endsection
