@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Client Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.settings.index') }}">
                                Clinic Settings
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Client Type</li>
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
                                <a href="#" id="newClientTypeBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Client Type
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="clientTypeData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Client Type</th>
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

        <div class="modal fade" id="newClientTypeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newClientTypeForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">New Client Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newClientType">Client Type</label>
                                <input type="text" name="type" class="form-control" id="newClientType"
                                    placeholder="Enter Client Type Name">
                            </div>

                            <div class="form-group">
                                <label for="newClientTypeDescription">Description</label>
                                <textarea name="description" id="newClientTypeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newClientTypeSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateClientTypeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateClientTypeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Client Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateClientTypeId" name="client_type_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateClientType">Client Type</label>
                                <input type="text" name="type" class="form-control" id="updateClientType"
                                    placeholder="Enter Client Type Name">
                            </div>

                            <div class="form-group">
                                <label for="updateClientTypeDescription">Description</label>
                                <textarea name="description" id="updateClientTypeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateClientTypeSubmitBtn" class="btn btn-primary">Update</button>
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

            find_client_type();

            function find_client_type() {
                var path = '{{ route('admin.client.type.index') }}';
                $('#clientTypeData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'type',
                            name: 'type'
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

            $('#newClientTypeBtn').click(function() {
                $('#newClientTypeModal').modal('show');
                $('#newClientTypeForm')[0].reset();
            });

            $('#newClientTypeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.client.type.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newClientTypeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newClientTypeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newClientTypeSubmitBtn').html('Save');
                        $('#newClientTypeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#newClientTypeModal').modal('hide');
                            $('#newClientTypeForm')[0].reset();
                            $('#clientTypeData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
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

            $(document).on('click', '.editClientType', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.client.type.show') }}';
                var client_type_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        client_type_id: client_type_id,
                        _token: token,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateClientTypeId').val(data['data']['id']);
                            $('#updateClientType').val(data['data']['type']);
                            $('#updateClientTypeDescription').val(data['data']['description']);
                            $('#updateClientTypeModal').modal('show');
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

            $('#updateClientTypeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.client.type.update') }}'
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateClientTypeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateClientTypeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateClientTypeSubmitBtn').html('Update');
                        $('#updateClientTypeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateClientTypeModal').modal('hide');
                            $('#updateClientTypeForm')[0].reset();
                            $('#clientTypeData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteClientType', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.client.type.delete') }}';
                var client_type_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this client type!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                client_type_id: client_type_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#clientTypeData').DataTable().ajax.reload();
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
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });
        });
    </script>
@endsection
