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
                        <li class="breadcrumb-item active">
                            {{ $page_title }}
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">
                                        My Scheduled Closed Bills
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">
                                        Physical Document Waiting to Send to HQ
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-five-profile" role="tab"
                                        aria-controls="custom-tabs-five-profile" aria-selected="false">
                                        Physical Document Sent to HQ
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="table-responsive">
                                        <table id="scheduledClosedBillsData"
                                            class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Invoice Number</th>
                                                    <th>Patient Names</th>
                                                    <th>Open Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Total Paid</th>
                                                    <th>Balance</th>
                                                    <th>Closed Date</th>
                                                    <th>Doctor/ Optimetrist</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($scheduledClosedPaymentsData as $scheduledClosedPayments)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->invoice_number }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->patient->first_name }}
                                                            {{ $scheduledClosedPayments->patient->last_name }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->open_date }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->total_amount }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->paid_amount }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->balance }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->close_date }}
                                                        </td>
                                                        <td>
                                                            {{ $scheduledClosedPayments->user->first_name }}
                                                            {{ $scheduledClosedPayments->user->last_name }}
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                data-id="{{ $scheduledClosedPayments->id }}"
                                                                class="btn btn-sm btn-success viewBtn">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">
                                    <form id="sendToHqForm">
                                        <span class="sendToHQSpan">
                                            <button type="submit" class="btn btn-block btn-outline-success">
                                                Send Doc To HQ
                                            </button>
                                        </span>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="physicalDocumentWaitingTobeSendData"
                                                class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>SN</th>
                                                        <th>Invoice Number</th>
                                                        <th>Patient Names</th>
                                                        <th>Open Date</th>
                                                        <th>Total Amount</th>
                                                        <th>Total Paid</th>
                                                        <th>Balance</th>
                                                        <th>Closed Date</th>
                                                        <th>Doctor/ Optimetrist</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($scheduledNotSentToHQClosedPaymentsData as $documentNotSent)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="payment_bill_id[]"
                                                                    value="{{ $documentNotSent->id }}">
                                                            </td>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                {{ $documentNotSent->invoice_number }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->patient->first_name }}
                                                                {{ $documentNotSent->patient->last_name }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->open_date }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->total_amount }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->paid_amount }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->balance }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->close_date }}
                                                            </td>
                                                            <td>
                                                                {{ $documentNotSent->user->first_name }}
                                                                {{ $documentNotSent->user->last_name }}
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)"
                                                                    data-id="{{ $documentNotSent->id }}"
                                                                    class="btn btn-sm btn-success viewBtn">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <span class="sendToHQSpan">
                                            <button type="submit" class="btn btn-block btn-outline-success">
                                                Send Doc To HQ
                                            </button>
                                        </span>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-five-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-five-profile-tab">
                                    <div class="table-responsive">
                                        <table id="physicalDocumentSendData"
                                            class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Invoice Number</th>
                                                    <th>Patient Names</th>
                                                    <th>Open Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Total Paid</th>
                                                    <th>Balance</th>
                                                    <th>Closed Date</th>
                                                    <th>Doctor/ Optimetrist</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($scheduledSentToHQClosedPaymentsData as $sendToHqData)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $sendToHqData->invoice_number }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->patient->first_name }}
                                                            {{ $sendToHqData->patient->last_name }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->open_date }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->total_amount }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->paid_amount }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->balance }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->close_date }}
                                                        </td>
                                                        <td>
                                                            {{ $sendToHqData->user->first_name }}
                                                            {{ $sendToHqData->user->last_name }}
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-id="{{ $sendToHqData->id }}"
                                                                class="btn btn-sm btn-success viewBtn">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            find_scheduled_closed_bills();

            function find_scheduled_closed_bills() {
                $("#scheduledClosedBillsData").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["excel", "print", "colvis"],
                    "pageLength": 10
                });
            }

            find_document_not_sent();

            function find_document_not_sent() {
                $("#physicalDocumentWaitingTobeSendData").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["excel", "print", "colvis"],
                    "pageLength": 10
                });
            }

            find_document_sent_to_hq();

            function find_document_sent_to_hq() {
                $("#physicalDocumentSendData").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["excel", "print", "colvis"],
                    "pageLength": 10
                });
            }

            $(document).on('click', '.viewBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url =
                                '{{ route('users.payments.close.bills.view', ':paymentBill') }}';
                            url = url.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 500);
                        }
                    },
                });
            });

            $(document).on('change', 'input[type="checkbox"]', function(e) {
                e.preventDefault();
                if ($('input[type="checkbox"]:checked').length > 0) {
                    $('.sendToHQSpan').fadeIn();
                } else {
                    $('.sendToHQSpan').fadeOut();
                }
            });

            $('#sendToHqForm').submit(function(e) {
                e.preventDefault();
                let payment_bill_id = [];
                $('input[type="checkbox"]:checked').each(function() {
                    payment_bill_id.push($(this).val());
                });
                if (payment_bill_id.length === 0) {
                    toastr.error('Please select bill');
                    return
                }
                let path = '{{ route('users.payments.close.bills.send.multiple.hq') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        payment_bill_id: payment_bill_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(this).find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $(this).find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        $(this).find('button[type=submit]').html(
                            'Send Doc To HQ'
                        );
                        $(this).find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
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
            });
        });
    </script>
@endpush
