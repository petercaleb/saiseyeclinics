<script>
    $(document).ready(function() {
        $("#data").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "print", "colvis"],
            "pageLength": 10
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $(document).on('click', '.newRoleBtn', function(e) {
            e.preventDefault();
            $('#newRoleModal').modal('show');
            $('#newRoleForm').trigger("reset");
        });

        $(document).on('click', '.deleteRoleBtn', function(e) {
            e.preventDefault();
            let role_id = $(this).data('id');
            let path = '{{ route('admin.roles.delete', ':id') }}';
            path = path.replace(":id", role_id);
            let token = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to remove this role',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: path,
                        data: {
                            _token: token
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        });
    });
</script>
