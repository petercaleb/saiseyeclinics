@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Doctors Schedules</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Doctors Schedules</li>
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
                        <div class="card-body table-responsive">
                            <table id="schedulesData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Day</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Doctor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_schedules();
            function find_schedules(){
                var path = '{{ route('admin.doctor.schedules.index', $clinic->id) }}';
                $('#schedulesData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'day',
                            name: 'day'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'time',
                            name: 'time'
                        },
                        {
                            data: 'dr_name',
                            name: 'dr_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    'responsive': true,
                    'autoWidth': false,
                    'paging': true,
                });
            }

            $(document).on('click', '.viewDoctorSchedule', function(e){
                e.preventDefault();
                let schedule_id = $(this).data('id');
                let path = '{{ route('admin.doctor.schedules.show', ':schedule_id') }}';
                path = path.replace(':schedule_id', schedule_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType:"json",
                    success:function(data){
                        if(data['status']){
                            let url = '{{ route('admin.doctor.schedules.view', [':id', ':schedule_id']) }}';
                            url = url.replace(':id', {{ $clinic->id }});
                            url = url.replace(':schedule_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
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
            });

        });
    </script>
@endsection
