<script>
    $(document).ready(function () {

        find_frame_stock_report();
        function find_frame_stock_report(from_date, to_date, payment_status, order_status)
        {
            let path = '{{ route('admin.hq.frames.report.get.frames.report') }}';
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
                        data: "frame.code",
                        name: "frame.code",
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'frame_color.color',
                        name: 'frame_color.color'
                    },
                    {
                        data: 'frame_shape.shape',
                        name: 'frame_shape.shape'
                    },
                    {
                        data: 'opening',
                        name: 'opening'
                    },
                    {
                        data: 'transfered',
                        name: 'transfered'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    }
                ],
                'responsive': true,
                'autoWidth': false,
            });
        }
    });
</script>