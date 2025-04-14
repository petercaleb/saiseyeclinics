@extends('admin.layouts.temp')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $clinic->clinic }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-users"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Patients
                            </span>
                            <span class="info-box-number">
                                1000
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Payments</h3>
                                <a href="{{ route('admin.payments.bills.index', $clinic->id) }}">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">KSHS {{ number_format($payments, 2) }}</span>
                                    <span>Total Payments made Over Time</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fa fa-square text-primary"></i> This year
                                </span>

                                <span>
                                    <i class="fa fa-square text-gray"></i> Last year
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Remittance</h3>
                                <a href="javascript:void(0);">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">KSH 0.00</span>
                                    <span>Total Claimed Remittance</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fa fa-square text-primary"></i> This Week
                                </span>

                                <span>
                                    <i class="fa fa-square text-gray"></i> Last Week
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Appointments</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Patient Names</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Client Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appointments as $appointment)
                                        <tr>
                                            <td>
                                                {{ $appointment->first_name }} {{ $appointment->last_name }}
                                            </td>
                                            <td>
                                                {{ $appointment->date }}
                                            </td>
                                            <td>
                                                {{ $appointment->appointment_time }}
                                            </td>
                                            <td>
                                                {{ $appointment->type }}
                                            </td>
                                            <td>
                                                @if ($appointment->status == 0)
                                                    <span class="badge badge-danger">Not Scheduled</span>
                                                @else
                                                    <span class="badge badge-success">Scheduled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" data-id="{{ $appointment->id }}"
                                                    class="btn btn-tool btn-sm viewAppointmentBtn">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                No Appointments added yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!--/.row -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.viewAppointmentBtn', function(e) {
                e.preventDefault();
                let appointment_id = $(this).data('id');
                let path = '{{ route('admin.appointments.show', ':appointment_id') }}';
                path = path.replace(':appointment_id', appointment_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url =
                                '{{ route('admin.appointments.view', [':id', ':appointment_id']) }}';
                            url = url.replace(':id', {{ $clinic->id }});
                            url = url.replace(':appointment_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    }
                });
            });

            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            find_payments_report();

            function find_payments_report() {
                var $salesChart = $('#sales-chart');
                var salesChart = new Chart($salesChart, {
                    type: 'bar',
                    data: {
                        labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                        datasets: [{
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                            },
                            {
                                backgroundColor: '#ced4da',
                                borderColor: '#ced4da',
                                data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
                            }
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,

                                    // Include a dollar sign in the ticks
                                    callback: function(value, index, values) {
                                        if (value >= 1000) {
                                            value /= 1000
                                            value += 'k'
                                        }
                                        return '$' + value
                                    }
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                });
            }

            find_remittance_report();

            function find_remittance_report() {
                var $visitorsChart = $('#visitors-chart');
                var visitorsChart = new Chart($visitorsChart, {
                    data: {
                        labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
                        datasets: [{
                                type: 'line',
                                data: [100, 120, 170, 167, 180, 177, 160],
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                pointBorderColor: '#007bff',
                                pointBackgroundColor: '#007bff',
                                fill: false
                                // pointHoverBackgroundColor: '#007bff',
                                // pointHoverBorderColor    : '#007bff'
                            },
                            {
                                type: 'line',
                                data: [60, 80, 70, 67, 80, 77, 100],
                                backgroundColor: 'tansparent',
                                borderColor: '#ced4da',
                                pointBorderColor: '#ced4da',
                                pointBackgroundColor: '#ced4da',
                                fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                            }
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,
                                    suggestedMax: 200
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                });
            }


        });
    </script>
@endpush
