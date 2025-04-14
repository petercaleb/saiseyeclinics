<script>
    $(document).ready(function() {

        $(document).on('click', '.enterAgreedAmountBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data['status']) {
                        $('#enterAgreedAmountBillId').val(data['data']['id']);
                        $('#enterAgreedAmountModal').modal('show');
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


        $('#enterAgreedAmountForm').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            let path = '{{ route('users.payments.bills.update.agreed.amount', $payment_bill->id) }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#enterAgreedAmountSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#enterAgreedAmountSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#enterAgreedAmountSubmitBtn').html('Enter');
                    $('#enterAgreedAmountSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        $('#enterAgreedAmountForm')[0].reset();
                        $('#enterAgreedAmountModal').modal('hide');
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
                },
            });
        });

        /// check approval status to updated approved number
        $('.approvalCard').fadeOut();
        $(document).on('change', '#enterAgreedApprovalStatus', function(e) {
            e.preventDefault();
            var approval_status = $(this).val();
            if (approval_status == 'APPROVED') {
                $('.approvalCard').fadeIn();
            } else {
                $('.approvalCard').fadeOut();
            }
        });

        $(document).on('click', '.addPaymentsBtn', function(e) {
            e.preventDefault();
            let payment_bill_id = $(this).attr('id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', payment_bill_id);
            $.ajax({
                url: path,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data['status']) {
                        $('#addPaymentsBillId').val(data['data']['id']);
                        $('#addPaymentsModal').modal('show');
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

        $('#addPaymentsForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var path = '{{ route('users.payments.billing.store', $payment_bill->id) }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#addPaymentsSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#addPaymentsSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#addPaymentsSubmitBtn').html('Add Payment');
                    $('#addPaymentsSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        $('#addPaymentsModal').modal('hide');
                        toastr.success(data['message']);
                        find_total_paid();
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

        function find_total_paid() {
            var bill_id = '{{ $payment_bill->id }}';
            var path = '{{ route('users.payments.billing.update.paid', $payment_bill->id) }}';
            var token = '{{ csrf_token() }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    '_token': token,
                    'bill_id': bill_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data['status']) {
                        location.reload();
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
        }

        $(document).on('click', '.rejectedInsuranceBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data['status']) {
                        $('#rejectedInsuranceBillId').val(data['data']['id']);
                        $('#rejectedInsuranceModal').modal('show');
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

        $('#rejectedInsuranceForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var path = '{{ route('users.payments.bills.update.consultation') }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#rejectedInsuranceSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#rejectedInsuranceSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#rejectedInsuranceSubmitBtn').html('Rejected');
                    $('#rejectedInsuranceSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        $('#rejectedInsuranceModal').modal('hide');
                        toastr.success(data['message']);
                        location.reload();
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