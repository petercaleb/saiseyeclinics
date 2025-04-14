<script>
    $(document).ready(function() {

        find_users();

        function find_users() {
            var path = '{{ route('admin.organization.users.index') }}';
            $('#usersData').DataTable({
                processing: true,
                serverSide: true,
                ajax: path,
                columns: [{
                        'data': 'DT_RowIndex',
                        'name': 'DT_RowIndex',
                    },
                    {
                        'data': 'clinic.clinic',
                        'name': 'clinic.clinic'
                    },
                    {
                        data: 'full_names',
                        name: 'full_names'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                ],
                'autoWidth': false,
                'responsive': true,
            });
        }
    });
</script>
