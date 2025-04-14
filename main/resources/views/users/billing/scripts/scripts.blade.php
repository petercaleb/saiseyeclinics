<script>
    $(document).ready(function() {

        $(document).on('click', '.proceedOrdersBtn', function(e) {
            e.preventDefault();
            var bill_id = $(this).data('id');
            var workshop_id = $(this).data('workshop');
            var lens_power_id = $(this).data('lens_power');
            var token = '{{ csrf_token() }}';
            var path = '{{ route('users.orders.store') }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    bill_id: bill_id,
                    workshop_id: workshop_id,
                    lens_power_id: lens_power_id
                },
                success: function(data) {
                    if (data['status']) {
                        find_order_track(data['order_id']);
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
                },
            });
        });


        function find_order_track(order_id) {

            var path = '{{ route('users.order.track.store') }}';
            var token = '{{ csrf_token() }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    order_id: order_id
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data.message);
                        let url = '{{ route('users.orders.view', ':id') }}';
                        url = url.replace(':id', order_id);
                        setTimeout(function() {
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
                },
            });
        }

        $(document).on('click', '.editPaymentBill', function(e) {
            e.preventDefault();
            let bill_id = $(this).attr('data-id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                success: function(data) {
                    if (data['status']) {
                        let edit_path =
                            '{{ route('users.payments.bills.edit', ':paymentBill') }}';
                        edit_path = edit_path.replace(':paymentBill', data['data']['id']);
                        setTimeout(() => {
                            window.location.href = edit_path;
                        }, 500);
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
                },
            });
        });

        $(document).on('click', '.printPaymentsBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data['status']) {
                        let url =
                            '{{ route('users.payments.bills.print', ':paymentBill') }}';
                        url = url.replace(':paymentBill', data['data']['id']);
                        setTimeout(() => {
                            window.open(url, "mywindow",
                                "status=1,toolbar=1");
                        }, 500);
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

        // close date
        $(document).on('click', '.closeBillBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data['status']) {
                        $('#closeBillId').val(data['data']['id']);
                        $('#closeBillModal').modal('show');
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

        $('#closeBillForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var path = '{{ route('users.payments.close.bills.store', $payment_bill->id) }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#closeBillSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#closeBillSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#closeBillSubmitBtn').html('Save');
                    $('#closeBillSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        $('#closeBillForm')[0].reset();
                        $('#closeBillModal').modal('hide');
                        let url = '{{ route('users.payments.close.bills.index') }}';
                        setTimeout(function() {
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

        // view order
        $(document).on('click', '.viewOrderBtn', function(e) {
            e.preventDefault();
            let order_id = $(this).data('id');
            let path = '{{ route('users.orders.show', ':order') }}';
            path = path.replace(':order', order_id);
            $.ajax({
                url: path,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data['status']) {
                        let url = '{{ route('users.orders.view', ':order') }}';
                        url = url.replace(':order', data['data']['id']);
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