<script>
    $(document).ready(function() {

        find_reports();

        function find_reports(from_date = '', to_date = '', payment_status = '', order_status = '') {
            var path = '{{ route('admin.main.reports.get.reports') }}';
            $('#reportsData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: path,
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        payment_status: payment_status,
                        order_status: order_status
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: "clinic",
                        name: "clinic",
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'appointment_date',
                        name: 'appointment_date'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'insurance',
                        name: 'insurance'
                    },
                    {
                        data: 'scheme',
                        name: 'scheme'
                    },
                    {
                        data: 'scheduled_date',
                        name: 'scheduled_date'
                    },
                    {
                        data: 'doctor_full_name',
                        name: 'doctor_full_name'
                    },
                    {
                        data: 'bill_status',
                        name: 'bill_status'
                    },
                    {
                        data: 'consultation_fee',
                        name: 'consultation_fee'
                    },
                    {
                        data: 'claimed_amount',
                        name: 'claimed_amount'
                    },
                    {
                        data: 'agreed_amount',
                        name: 'agreed_amount'
                    },
                    {
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status'
                    },
                    {
                        data: 'workshop',
                        name: 'workshop'
                    }
                ],
                'responsive': true,
                'autoWidth': false,
            });
        }

        $('.filterReportsByDatesRow').fadeOut(500);
        $('.filterReportsByPaymentsRow').fadeOut(500);
        $('.filterReportsByOrdersRow').fadeOut(500);

        $(document).on('click', '#refresh', function(e) {
            e.preventDefault();
            $('#fromDate').val('');
            $('#toDate').val('')
            $('#reportsData').DataTable().destroy();
            find_reports();
        });

        $(document).on('click', '#refreshReportsAllReports', function(e) {
            e.preventDefault();
            $('.filterReportsByDatesRow').fadeOut(500);
            $('.filterReportsByPaymentsRow').fadeOut(500);
            $('.filterReportsByOrdersRow').fadeOut(500);
            setTimeout(() => {
                location.reload();
            }, 1000);
        });

        $(document).on('click', '#filterReportsByDate', function(e) {
            e.preventDefault();
            $('.filterReportsByDatesRow').fadeIn(800);
            $('.filterReportsByPaymentsRow').fadeOut(500);
            $('.filterReportsByOrdersRow').fadeOut(500);
        });

        $(document).on('click', '#filter', function(e) {
            e.preventDefault();
            var from_date = $('#fromDate').val();
            var to_date = $('#toDate').val();
            if (from_date != '' && to_date != '') {
                $('#reportsData').DataTable().destroy();
                find_reports(from_date, to_date);
            } else {
                toastr.error('Both Date is required');
            }
        });

        $(document).on('click', '#filterReportsByPayments', function(e) {
            e.preventDefault();
            $('.filterReportsByDatesRow').fadeOut(500);
            $('.filterReportsByPaymentsRow').fadeIn(800);
            $('.filterReportsByOrdersRow').fadeOut(500);
        });

        $(document).on('click', '#filtePaymentStatus', function(e) {
            e.preventDefault();
            let paymentStatus = $('#paymentStatus').val();
            if (paymentStatus != null) {
                $('#reportsData').DataTable().destroy();
                find_reports(from_date = '', to_date = '', paymentStatus);
            } else {
                toastr.warning("Please select a Payment Status");
            }
        });

        $(document).on('click', '#filterReportsByOrders', function(e) {
            e.preventDefault();
            $('.filterReportsByDatesRow').fadeOut(500);
            $('.filterReportsByPaymentsRow').fadeOut(500);
            $('.filterReportsByOrdersRow').fadeIn(800);
        });

        $(document).on('click', '#filteOrderStatus', function(e) {
            e.preventDefault();
            let orderStatus = $('#ordersStatus').val();
            if (orderStatus != null) {
                $('#reportsData').DataTable().destroy();
                find_reports(from_date = '', to_date = '', payment_status = '', orderStatus);
            } else {
                toastr.warning("Please select an Order Status");
            }
        });

    });
</script>