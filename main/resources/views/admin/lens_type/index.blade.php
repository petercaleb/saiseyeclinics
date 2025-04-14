@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lens Type</h1>
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
                        <li class="breadcrumb-item active">Lens Type</li>
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
                                <a href="#" id="newLensTypeBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Lens Type
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="lensTypeData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Lens Type</th>
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

        <div class="modal fade" id="newLensTypeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newLensTypeForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">New Lens Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newLensType">Lens Type</label>
                                <input type="text" name="type" class="form-control" id="newLensType"
                                    placeholder="Enter Lens Type Name">
                            </div>

                            <div class="form-group">
                                <label for="newLensTypeDescription">Description</label>
                                <textarea name="description" id="newLensTypeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newLensTypeSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateLensTypeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateLensTypeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Lens Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateLensTypeId" name="type_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateLensType">Lens Type</label>
                                <input type="text" name="type" class="form-control" id="updateLensType"
                                    placeholder="Enter Lens Type Name">
                            </div>

                            <div class="form-group">
                                <label for="updateLensTypeDescription">Description</label>
                                <textarea name="description" id="updateLensTypeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateLensTypeSubmitBtn" class="btn btn-primary">Update</button>
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

            find_lens_type();

            function find_lens_type() {
                let path = '{{ route('admin.settings.workshops.lens.type.index') }}';
                $('#lensTypeData').DataTable({
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

            $('#newLensTypeBtn').click(function() {
                $('#newLensTypeModal').modal('show');
                $('#newLensTypeForm')[0].reset();
            });

            $('#newLensTypeForm').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.workshops.lens.type.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newLensTypeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newLensTypeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newLensTypeSubmitBtn').html('Save');
                        $('#newLensTypeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensTypeModal').modal('hide');
                            $('#newLensTypeForm')[0].reset();
                            $('#lensTypeData').DataTable().ajax.reload();
                        }
                    },
                    error: function(data){
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

            $(document).on('click', '.editLensType', function(e) {
                e.preventDefault();
                let path = '{{ route('admin.settings.workshops.lens.type.show') }}';
                let type_id = $(this).data('id');
                let token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        type_id: type_id,
                        _token: token,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLensTypeId').val(data['data']['id']);
                            $('#updateLensType').val(data['data']['type']);
                            $('#updateLensTypeDescription').val(data['data']['description']);
                            $('#updateLensTypeModal').modal('show');
                        }
                    },
                    error: function(data){
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

            $('#updateLensTypeForm').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.workshops.lens.type.update') }}'
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateLensTypeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateLensTypeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateLensTypeSubmitBtn').html('Update');
                        $('#updateLensTypeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateLensTypeModal').modal('hide');
                            $('#updateLensTypeForm')[0].reset();
                            $('#lensTypeData').DataTable().ajax.reload();
                        }
                    },
                    error: function(data){
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

            $(document).on('click', '.deleteLensType', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.settings.workshops.lens.type.delete') }}';
                var type_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this lens type!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                type_id: type_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#lensTypeData').DataTable().ajax.reload();
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
