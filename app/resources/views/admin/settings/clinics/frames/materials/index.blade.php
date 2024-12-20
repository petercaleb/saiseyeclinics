@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frame Materials</h1>
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
                            Frame Materials
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
                                <a href="#" id="newFrameMaterialBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Frame Material
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="frameMaterialsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newFrameMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newFrameMaterialForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Frame Material</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newFrameMaterialTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newFrameMaterialTitle"
                                    placeholder="Frame Material Title">
                            </div>

                            <div class="form-group">
                                <label for="ewFrameMaterialDescription">Description</label>
                                <textarea name="description" id="newFrameMaterialDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newFrameMaterialSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateFrameMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateFrameMaterialForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Frame Material</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateFrameMaterialId" name="type_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateFrameMaterialTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateFrameMaterialTitle"
                                    placeholder="Frame Material Title">
                            </div>

                            <div class="form-group">
                                <label for="updateFrameMaterialDescription">Description</label>
                                <textarea name="description" id="updateFrameMaterialDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateFrameMaterialSubmitBtn" class="btn btn-primary">Update</button>
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

            find_frame_materials();

            function find_frame_materials() {
                var path = "{{ route('admin.settings.clinics.frames.materials.index') }}";
                $('#frameMaterialsData').DataTable({
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

            $('#newFrameMaterialBtn').click(function(e) {
                e.preventDefault();
                $('#newFrameMaterialModal').modal('show');
            });

            $('#newFrameMaterialForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.frames.materials.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newFrameMaterialSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newFrameMaterialSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newFrameMaterialSubmitBtn').html('Save');
                        $('#newFrameMaterialSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newFrameMaterialModal').modal('hide');
                            $('#newFrameMaterialForm')[0].reset();
                            $('#frameMaterialsData').DataTable().ajax.reload();
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

            $(document).on('click', '.editFrameMaterial', function(e) {
                e.preventDefault();
                var material_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.frames.materials.show') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        material_id: material_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateFrameMaterialId').val(data['data']['id']);
                            $('#updateFrameMaterialTitle').val(data['data']['title']);
                            $('#updateFrameMaterialDescription').val(data['data'][
                                'description']);
                            $('#updateFrameMaterialModal').modal('show');
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

            $('#updateFrameMaterialForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var material_id = $('#updateFrameMaterialId').val();
                let path = '{{ route('admin.settings.clinics.frames.materials.update', ':id') }}';
                path = path.replace(':id', material_id);
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
                        $('#updateFrameMaterialSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateFrameMaterialSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateFrameMaterialSubmitBtn').html('Save');
                        $('#updateFrameMaterialSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateFrameMaterialModal').modal('hide');
                            $('#updateFrameMaterialForm')[0].reset();
                            $('#frameMaterialsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteFrameMaterial', function(e) {
                e.preventDefault();
                var material_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.frames.materials.delete', ':id') }}";
                path = path.replace(':id', material_id);
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
                                    $('#frameMaterialsData').DataTable().ajax.reload();
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
