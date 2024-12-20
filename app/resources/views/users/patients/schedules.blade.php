@extends('users.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.patients.index') }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $patient->first_name }} {{ $patient->last_name }} Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('users.includes.patients.sidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Doctor</th>
                                                    <th>Schedule Day</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($schedules as $schedule)
                                                    <tr>
                                                        <td>
                                                            {{ $schedule->user->first_name }}
                                                            {{ $schedule->user->last_name }}
                                                        </td>
                                                        <td>
                                                            {{ $schedule->day }}
                                                        </td>
                                                        <td>
                                                            {{ $schedule->date }}
                                                        </td>
                                                        <td>
                                                            {{ date('h:i A', strtotime($schedule->time)) }}
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->id == $schedule->user_id)
                                                                <a href="#" data-id="{{ $schedule->id }}"
                                                                    class="btn btn-success viewScheduleBtn">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                SCHEDULED
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="text-center">
                                                                No Schedules
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--/.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            
            $(document).on('click', '.viewScheduleBtn', function(e) {
                e.preventDefault();
                var schedule_id = $(this).data('id');
                var path = '{{ route('users.doctor.schedules.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        schedule_id: schedule_id,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data) {
                        let url = '{{ route('users.doctor.schedules.view', ':id') }}';
                        url = url.replace(':id', data['data']['id']);
                        setTimeout(() => {
                            window.location.href = url;
                        }, 1000);
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

        });
    </script>
@endpush
