@if (Route::is('admin.banking.index'))
    <script>
        $(document).ready(function() {

            $("#submittedData").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "print", "colvis"],
                "pageLength": 10
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#paymentsData").DataTable({
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

            $(document).on('click', '#newBankingBtn', function(e) {
                e.preventDefault();
                $("#newBankingModal").modal('show');
                $('#newBankingForm').trigger("reset");
            });

            $(document).on('change', '#newBankingInsurance', function(e) {
                e.preventDefault();
                let insurance_id = $(this).val();
                let path = '{{ route('admin.banking.get.remmittance', ':id') }}';
                path = path.replace(':id', insurance_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#newBankingReceivedRemmittance').empty();
                            $.each(data['data'], function(key, value) {
                                console.log(value);
                                $('#newBankingReceivedRemmittance').append(
                                    '<option value="' + value.id + '">' + value
                                    .payment_bill.patient.first_name + ' ' + value
                                    .payment_bill.patient.last_name + '</option>');
                            });
                        }
                    }
                });
            });

            let selectedRemittanceIds = [];
            let totalAmount = 0;

            function updateSelectedRemittances() {
                selectedRemittanceIds = [];
                totalAmount = 0; // Reset total amount

                // Track checkbox selections
                $('.submitRemmittanceCheckBox:checked').each(function() {
                    selectedRemittanceIds.push($(this).val());
                    totalAmount += parseFloat($(this).data('amount')); // Add the amount of each checked checkbox
                });

                // Show or hide the submit button
                if (selectedRemittanceIds.length > 0) {
                    $('.receivePaymentsBtnRow').fadeIn();
                    $('#newBankingAgreedAmount').val(totalAmount.toFixed(2)); // Display the total amount
                } else {
                    $('.receivePaymentsBtnRow').fadeOut();
                    $('#newBankingAgreedAmount').val(''); // Clear the amount field
                }
            }

            $('#selectAllCheckbox').on('change', function() {
                // Check or uncheck all checkboxes in the table body
                $('.submitRemmittanceCheckBox').prop('checked', $(this).prop('checked'));
                updateSelectedRemittances(); // Update after select all is checked/unchecked
            });

            $(document).on('change', '.submitRemmittanceCheckBox', function(e) {
                e.preventDefault();
                if (!$(this).prop('checked')) {
                    $('#selectAllCheckbox').prop('checked', false);
                }

                // Check "select all" if all individual checkboxes are checked
                if ($('.submitRemmittanceCheckBox:checked').length === $('.submitRemmittanceCheckBox')
                    .length) {
                    $('#selectAllCheckbox').prop('checked', true);
                }

                updateSelectedRemittances(); // Update selected IDs and amount
            });

            // Open the modal when the submit button is clicked
            $(document).on('click', '.receivePaymentsBtn', function(e) {
                e.preventDefault();
                $('#newBankingModal').modal('show');
            });

            $('#newBankingForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(form[0]);

                // Append the selected remittance IDs
                selectedRemittanceIds.forEach(function(id) {
                    formData.append('remmittance_id[]',
                        id); // Ensure `[]` is added to handle multiple IDs
                });

                // Debug: Log the FormData contents to ensure remmittance_id is being appended
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.banking.store') }}",
                    data: formData,
                    dataType: "json",
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    beforeSend: function() {
                        $(this).find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $(this).find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        $(this).find('button[type=submit]').html(
                            'Save'
                        );
                        $(this).find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $("#newBankingModal").modal('hide');
                            $('#newBankingForm').trigger("reset");
                            let bankingPath = '{{ route('admin.banking.view', ':id') }}';
                            bankingPath = bankingPath.replace(':id', data['bank_id']);
                            setTimeout(() => {
                                window.location.href = bankingPath;
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
@endif
