@extends('admin.layouts.auth')

@section('content')
    <p class="login-box-msg">Add My Organization/Company</p>

    <form id="organizationForm">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="organizationName" name="organization" placeholder="Organization Name">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-bank"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="organizationTagline" name="tagline" placeholder="Tagline">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-briefcase"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="organizationPhone" name="phone" placeholder="Phone Number">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-phone"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="email" name="email" id="organizationEmail" class="form-control" placeholder="Email Address">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="organizationLocation" name="location" placeholder="Location">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-map"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                &nbsp;
            </div>
            <!-- /.col -->
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-block">Add</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#organizationForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                var path = '{{ route('admin.organization.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        form.find('button[type="submit"]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type="submit"]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type="submit"]').html('Add');
                        form.find('button[type="submit"]').attr('disabled', false);
                    },

                    success: function(response) {
                        if (response['status']) {
                            toastr.success(response['message']);
                            setTimeout(function() {
                                window.location.href =
                                    '{{ route('admin.organization.index') }}';
                            }, 2000);
                        } else {
                            console.log(response);
                        }
                    }
                });
            });
        });
    </script>
@endsection
