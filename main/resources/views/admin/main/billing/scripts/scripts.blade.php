<script>
    $(document).ready(function() {

        $("#data").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#sentToHqData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#receivedData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $(document).on('click', '.receiveDocumentBtn', function(e) {
            e.preventDefault();
            let payment_id = $(this).data('id');
            let path = '{{ route('admin.billing.receive', ':paymentBill') }}';
            path = path.replace(':paymentBill', payment_id);
            let token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: path,
                data: {
                    _token: token
                },
                dataType: "json",
                beforeSend: function() {
                    $('.receiveDocumentBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>'
                    );
                    $('.receiveDocumentBtn').attr('disabled', true);
                },
                complete: function() {
                    $('.receiveDocumentBtn').html(
                        '<i class="fa fa-cog"></i> Receive Document'
                    );
                    $('.receiveDocumentBtn').attr('disabled', false);
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

        $(document).on('change', '.receivedDocumentsCheckBox', function(e) {
            e.preventDefault();
            if ($('input[type="checkbox"]:checked').length > 0) {
                $('.receiveDocumentSpan').fadeIn();
            } else {
                $('.receiveDocumentSpan').fadeOut();;
            }
        });

        $('#receiveDocumentsForm').submit(function(e) {
            e.preventDefault();
            let payment_bill_id = [];
            $('input[type="checkbox"]:checked').each(function() {
                payment_bill_id.push($(this).val());
            });
            if (payment_bill_id.length === 0) {
                toastr.error('Please select bill');
                return
            }
            let path = '{{ route('admin.billing.receive.multiple.docs') }}';
            let token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: path,
                data: {
                    payment_bill_id: payment_bill_id,
                    _token: token
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
                        ' Receive Document'
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

        $(document).on('change', '.createRemmittanceCheckBox', function(e) {
            e.preventDefault();
            if ($('input[type="checkbox"]:checked').length > 0) {
                $('.submitRemmittanceSpan').fadeIn();
            } else {
                $('.submitRemmittanceSpan').fadeOut();;
            }
        });

        $('#createRemmittanceForm').submit(function(e) {
            e.preventDefault();
            let payment_bill_id = [];
            $('input[type="checkbox"]:checked').each(function() {
                payment_bill_id.push($(this).val());
            });
            if (payment_bill_id.length === 0) {
                toastr.error('Please select bill');
                return
            }
            let path = '{{ route('admin.billing.store.remmittance') }}';
            let token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: path,
                data: {
                    payment_bill_id: payment_bill_id,
                    _token: token
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
                        'Create Remmittance'
                    );
                    $(this).find('button[type=submit]').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        setTimeout(() => {
                            window.location.href = '{{ route('admin.remmittance.index') }}'
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
