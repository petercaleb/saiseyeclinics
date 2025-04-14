@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ $clinic->clinic }} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Patient Self Registration Link
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Clinic</strong>

                            <p class="text-muted">
                                {{ $clinic->clinic }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Self Registration Link</strong>

                            <p class="text-muted">
                                {{ $clinic->self_registration_link }}
                            </p>
                            <hr>
                            @if ($clinic->qr_code_path)
                                <strong><i class="fas fa-qrcode mr-1"></i> QR Code</strong>

                                <p class="text-muted">
                                    <img src="{{ asset('storage/' . $clinic->qr_code_path) }}"
                                        alt="QR Code for {{ $clinic->clinic }}" width="150">
                                </p>
                                <hr>
                            @endif
                            @if (!isset($clinic->self_registration_link))
                                <button type="button"
                                    class="btn btn-outline-success btn-block generateSelfRegistrationLinkBtn">
                                    Generate Self Registration Link
                                </button>
                            @endif

                            <!-- Download Button -->
                            @if ($clinic->qr_code_path)
                                <a href="{{ asset('storage/' . $clinic->qr_code_path) }}"
                                    download="QRCode-{{ $clinic->clinic }}.png" class="btn btn-outline-primary btn-block">
                                    Download QR Code
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.generateSelfRegistrationLinkBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('users.patients.self.registration.generate') }}';
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You're going to generate self registration link for patients",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
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
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

        });
    </script>
@endpush
