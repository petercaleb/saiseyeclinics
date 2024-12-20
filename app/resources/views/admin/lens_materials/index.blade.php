@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lens Materials</h1>
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
                        <li class="breadcrumb-item active">Lens Materials</li>
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
                                <a href="#" id="newLensMaterialBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Material
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="lensMaterialsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newLensMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newLensMaterialForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">New Lens Material</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newLensMaterialTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newLensMaterialTitle"
                                    placeholder="Enter Title">
                            </div>

                            <div class="form-group">
                                <label for="newLensMaterialDescription">Description</label>
                                <textarea name="description" id="newLensMaterialDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newLensMaterialSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateLensMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateLensMaterialForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Lens Material</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateLensMaterialId" name="material_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateLensMaterialTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateLensMaterialTitle"
                                    placeholder="Enter Title">
                            </div>

                            <div class="form-group">
                                <label for="updateLensMaterialDescription">Description</label>
                                <textarea name="description" id="updateLensMaterialDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateLensMaterialSubmitBtn" class="btn btn-primary">Update</button>
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

            find_lens_materials();

            function find_lens_materials() {
                var path = '{{ route('admin.settings.workshops.lens.material.index') }}';
                $('#lensMaterialsData').DataTable({
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

            $('#newLensMaterialBtn').click(function(e) {
                e.preventDefault();
                $('#newLensMaterialModal').modal('show');
                $('#newLensMaterialForm')[0].reset();
            });

            $('#newLensMaterialForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.workshops.lens.material.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newLensMaterialSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newLensMaterialSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newLensMaterialSubmitBtn').html('Save');
                        $('#newLensMaterialSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensMaterialModal').modal('hide');
                            $('#newLensMaterialForm')[0].reset();
                            $('#lensMaterialsData').DataTable().ajax.reload();
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

            $(document).on('click', '.editMaterialBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.settings.workshops.lens.material.show') }}';
                var material_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        material_id: material_id,
                        _token: token,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLensMaterialId').val(data['data']['id']);
                            $('#updateLensMaterialTitle').val(data['data']['title']);
                            $('#updateLensMaterialDescription').val(data['data']['description']);
                            $('#updateLensMaterialModal').modal('show');
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

            $('#updateLensMaterialForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.workshops.lens.material.update') }}'
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateLensMaterialSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateLensMaterialSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateLensMaterialSubmitBtn').html('Update');
                        $('#updateLensMaterialSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateLensMaterialModal').modal('hide');
                            $('#updateLensMaterialForm')[0].reset();
                            $('#lensMaterialsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteMaterialBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.settings.workshops.lens.material.delete') }}';
                var material_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this lens material!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                material_id: material_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#lensMaterialsData').DataTable().ajax.reload();
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
