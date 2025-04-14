@extends('users.layouts.auth')

@section('content')
    <p class="login-box-msg">Register here</p>

    <form id="patientRegistrationForm" method="post">
        @csrf
        <div class="form-step active">
            <div class="input-group mb-3">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user-alt"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user-alt"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="id_number" class="form-control" placeholder="ID Number" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user-secret"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-phone-alt"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="dob" class="form-control datepicker" placeholder="Date of Birth">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select name="gender" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="address" class="form-control" placeholder="Address">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-address-book"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="next_of_kin" class="form-control" placeholder="Next of Kin">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="next_of_kin_contact" class="form-control" placeholder="Next of Kin Contacts">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-phone-alt"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-block next-btn">Next</button>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div class="form-step">
            <div class="input-group mb-3">
                <select name="client_type_id" id="client_type_id" class="form-control select2" style="width: 100%;">
                    <option selected="selected" disabled>Select Client Type</option>
                    @foreach ($client_types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="insurancePatientColumn">
                <div class="input-group mb-3">
                    <select name="insurance_id" class="form-control select2" style="width: 100%;">
                        <option selected="selected" disabled>Select Insurance</option>
                        @foreach ($insurances as $ins)
                            <option value="{{ $ins->id }}">
                                {{ $ins->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <input type="text" id="scheme" name="scheme" class="form-control" placeholder="Scheme Name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-project-diagram"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" id="principal" name="principal" class="form-control"
                        placeholder="Principal Member Name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" id="principal_phone" name="principal_phone" class="form-control"
                        placeholder="Principal Member Phone">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone-alt"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" id="card_number" name="card_number" class="form-control"
                        placeholder="Insurance Card Number">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-shield-alt"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" id="workplace" name="workplace" class="form-control" placeholder="Workplace">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-building"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <button type="button" class="btn btn-default btn-block back-btn">
                        Back
                    </button>
                </div>
                <div class="col-12 col-md-6">
                    <button type="submit" class="btn btn-primary btn-block">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#patientRegistrationForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.self.registration.store', $clinic->id) }}';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: path,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
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
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(data) {
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

            // On clicking the next button
            $(".next-btn").click(function() {
                let currentStep = $(this).closest(".form-step");
                let nextStep = currentStep.next(".form-step");

                // Hide current step and show the next one
                currentStep.removeClass("active");
                nextStep.addClass("active");
            });

            // On clicking the back button
            $(".back-btn").click(function() {
                let currentStep = $(this).closest(".form-step");
                let previousStep = currentStep.prev(".form-step");

                // Hide current step and show the previous one
                currentStep.removeClass("active");
                previousStep.addClass("active");
            });

            $('.insurancePatientColumn').fadeOut();

            $(document).on('change', '#client_type_id', function(e) {
                e.preventDefault();
                var type_id = $(this).val();
                var path = '{{ route('users.self.client.type', ':id') }}';
                path = path.replace(':id', type_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['type'] == "Insurance") {
                            $('.insurancePatientColumn').fadeIn();
                        }
                        if (data['type'] == "Cash and Insurance") {
                            $('.insurancePatientColumn').fadeIn();
                        }
                        if (data['type'] == "Cash") {
                            $('.insurancePatientColumn').fadeOut();
                        }

                    }
                });
            });

        });
    </script>
@endsection
