@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Status</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Status</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="#" id="newStatusBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Status
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="statusData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="modal fade" id="newStatusModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newStatusForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">New Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newStatusTitle">Status</label>
                                <input type="text" name="title" class="form-control" id="newStatusTitle"
                                    placeholder="Enter Status">
                            </div>

                            <div class="form-group">
                                <label for="newStatusDescription">Description</label>
                                <textarea name="description" id="newStatusDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newStatusSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateStatusModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateStatusForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateStatusId" name="status_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateStatusTitle">Status</label>
                                <input type="text" name="title" class="form-control" id="updateStatusTitle"
                                    placeholder="Enter Status">
                            </div>

                            <div class="form-group">
                                <label for="updateStatusDescription">Description</label>
                                <textarea name="description" id="updateStatusDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateStatusSubmitBtn" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_status();

            function find_status() {
                var path = '{{ route('admin.status.index') }}';
                $('#statusData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'slug',
                            name: 'slug'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('#newStatusBtn').click(function(e) {
                e.preventDefault();
                $('#newStatusModal').modal('show');
                $('#newStatusForm')[0].reset();
            });

            $('#newStatusForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.status.store') }}'
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newStatusSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newStatusSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newStatusSubmitBtn').html('Save');
                        $('#newStatusSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newStatusModal').modal('hide');
                            $('#newStatusForm')[0].reset();
                            $('#statusData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.status.show') }}';
                var status_id = $(this).attr('id');
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        status_id: status_id,
                        _token: token,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateStatusId').val(data['data']['id']);
                            $('#updateStatusTitle').val(data['data']['title']);
                            $('#updateStatusDescription').val(data['data']['description']);
                            $('#updateStatusModal').modal('show');
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $('#updateStatusForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.status.update') }}'
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateStatusSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateStatusSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateStatusSubmitBtn').html('Update');
                        $('#updateStatusSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateStatusModal').modal('hide');
                            $('#updateStatusForm')[0].reset();
                            $('#statusData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.status.delete') }}';
                var status_id = $(this).attr('id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this status!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                status_id: status_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#statusData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

        });
    </script>
@endsection
