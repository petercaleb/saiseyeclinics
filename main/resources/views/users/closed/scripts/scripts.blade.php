<script>
    $(document).ready(function() {

        $(document).on('click', '.updateKRANumberBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            $.ajax({
                url: path,
                type: 'GET',
                success: function(data) {
                    if (data['status']) {
                        $('#updateKRANumberBillId').val(data['data']['id']);
                        $('#updateKRANumberModal').modal('show');
                    }
                },
            });
        });

        $('#updateKRANumberForm').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            let path = '{{ route('users.payments.close.bills.update.lpo', $payment_bill->id) }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    form.find('button[type=submit]').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    form.find('button[type=submit]').attr('disabled', true);
                },
                complete: function() {
                    form.find('button[type=submit]').html(
                        'Update'
                    );
                    form.find('button[type=submit]').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        $('#updateLPONumberModal').modal('hide');
                        toastr.success(data['message']);
                        setTimeout(function() {
                            window.location.reload();
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

        $(document).on('click', '.printPaymentsBtn', function(e) {
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
                            '{{ route('users.payments.close.bills.print', ':paymentBill') }}';
                        url = url.replace(':paymentBill', data['data']['id']);
                        setTimeout(() => {
                            window.open(url, "mywindow",
                                "status=1,toolbar=1");
                        }, 500);
                    }
                }
            });
        });

        $(document).on('click', '.sendDocToHQBtn', function(e) {
            e.preventDefault();
            let bill_id = $(this).data('id');
            let path = '{{ route('users.payments.close.bills.send.to.hq', ':paymentBill') }}';
            path = path.replace(':paymentBill', bill_id);
            let token = '{{ csrf_token() }}'
            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token
                },
                dataType: "json",
                beforeSend: function() {
                    $('.sendDocToHQBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('.sendDocToHQBtn').attr('disabled', true);
                },
                complete: function() {
                    $('.sendDocToHQBtn').html(
                        'Send Doc To HQ'
                    );
                    $('.sendDocToHQBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },

            });
        });

        $(document).on('click', '.addAttachmentsBtn', function(e) {
            e.preventDefault();
            // $('#fileUpload').trigger('click');
            let paymentBill = $(this).data('id');
            let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
            path = path.replace(':paymentBill', paymentBill);
            $.ajax({
                type: "GET",
                url: path,
                dataType: "json",
                success: function(data) {
                    if (data['status']) {
                        $('#addAttachmentModal').modal('show');
                        $('#addAttachmentPaymentId').val(data['data']['id']);
                    }
                }
            });
        });

        $('#addAttachmentForm').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            let paymentBill = $('#addAttachmentPaymentId').val();
            let path = '{{ route('users.payments.attachments.store', ':paymentBill') }}';
            path = path.replace(':paymentBill', paymentBill);
            $.ajax({
                type: "POST",
                url: path,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    form.find('button[type=submit]').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    form.find('button[type=submit]').attr('disabled', true);
                },
                complete: function() {
                    form.find('button[type=submit]').html(
                        'Save');
                    form.find('button[type=submit]').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        $('#addAttachmentModal').modal('hide');
                        $('#addAttachmentForm')[0].reset();
                        setTimeout(() => {
                            location.reload();
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

        $('.attachmentsBtn').click(function(e) {
            e.preventDefault();
            $('#attachmentsModal').modal('show');
        });
    });
</script>
