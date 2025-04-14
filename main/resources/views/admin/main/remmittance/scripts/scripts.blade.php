<script>
    $(document).ready(function() {
        $("#data").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#pendingData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#submittedData").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $(document).on('change', '.submitRemmittanceCheckBox', function(e) {
            e.preventDefault();
            if ($('input[type="checkbox"]:checked').length > 0) {
                $('.submitRemmittanceSpan').fadeIn();
            } else {
                $('.submitRemmittanceSpan').fadeOut();
            }
        });

        $('#submitRemmittanceForm').submit(function(e) {
            e.preventDefault();
            let remmittance_id = [];
            $('input[type="checkbox"]:checked').each(function() {
                remmittance_id.push($(this).val());
            });
            if (remmittance_id.length === 0) {
                toastr.error('Please select remmittance');
                return
            }
            let path = '{{ route('admin.remmittance.submit.remmittance') }}';
            let token = '{{ csrf_token() }}';
            $.ajax({
                type: "POST",
                url: path,
                data: {
                    remmittance_id: remmittance_id,
                    _token: token
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    if (response['status']) {
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    // let blob = new Blob([response], {
                    //     type: 'application/pdf'
                    // });
                    // let link = document.createElement('a');
                    // link.href = window.URL.createObjectURL(blob);
                    // link.download = 'remmittance.pdf';
                    // link.click();
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
