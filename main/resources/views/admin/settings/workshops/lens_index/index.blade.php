@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lens Index</h1>
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
                        <li class="breadcrumb-item active">
                            Lens Index
                        </li>
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
                                <a href="#" id="newLensIndexBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Lens Index
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="indexData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newLensIndexModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newLensIndexForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Lens Index</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newLensIndexTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newLensIndexTitle"
                                    placeholder="Lens Index Title">
                            </div>

                            <div class="form-group">
                                <label for="newLensIndexDescription">Description</label>
                                <textarea name="description" id="newLensIndexDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newLensIndexSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateLensIndexModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateLensIndexForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Lens Index</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateLensIndexId" name="index_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateLensIndexTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateLensIndexTitle"
                                    placeholder="Lens Index Title">
                            </div>

                            <div class="form-group">
                                <label for="updateLensIndexDescription">Description</label>
                                <textarea name="description" id="updateLensIndexDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateLensIndexSubmitBtn" class="btn btn-primary">Update</button>
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

            find_index();

            function find_index() {
                var path = "{{ route('admin.settings.workshops.lens.index.index') }}";
                $('#indexData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": path,
                    'responsive': true,
                    'autoWidth': false,
                    "columns": [{
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
                    ]
                });
            }

            $('#newLensIndexBtn').click(function(e) {
                e.preventDefault();
                $('#newLensIndexModal').modal('show');
                $('#newLensIndexForm')[0].reset();
            });

            $('#newLensIndexForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.workshops.lens.index.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newLensIndexSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newLensIndexSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newLensIndexSubmitBtn').html('Save');
                        $('#newLensIndexSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensIndexModal').modal('hide');
                            $('#newLensIndexForm')[0].reset();
                            $('#indexData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteLensIndexBtn', function(e){
                e.preventDefault();
                var index_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.workshops.lens.index.delete', ':id') }}";
                path = path.replace(':id', index_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#indexData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.updateLensIndexBtn', function(e) {
                e.preventDefault();
                var index_id = $(this).data('id');
                var path = "{{ route('admin.settings.workshops.lens.index.show', ':id') }}";
                path = path.replace(':id', index_id);
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLensIndexModal').modal('show');
                            $('#updateLensIndexId').val(data['data']['id']);
                            $('#updateLensIndexTitle').val(data['data']['title']);
                            $('#updateLensIndexDescription').val(data['data']['description']);
                            
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

            $('#updateLensIndexForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var index_id = $('#updateLensIndexId').val();
                let path = '{{ route('admin.settings.workshops.lens.index.update', ':id') }}';
                path = path.replace(':id', index_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateLensIndexSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateLensIndexSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateLensIndexSubmitBtn').html('Update');
                        $('#updateLensIndexSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateLensIndexModal').modal('hide');
                            $('#updateLensIndexForm')[0].reset();
                            $('#indexData').DataTable().ajax.reload();
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
@endsection
