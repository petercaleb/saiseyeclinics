@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frame Colors</h1>
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
                            Frame Colors
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
                                <a href="#" id="newFrameColorBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Frame Color
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="frameColorsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Color</th>
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

        <div class="modal fade" id="newFrameColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newFrameColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Frame Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newFrameColor">Color</label>
                                <input type="text" name="color" class="form-control" id="newFrameColor"
                                    placeholder="Enter Frame Color">
                            </div>

                            <div class="form-group">
                                <label for="newFrameColorDescription">Description</label>
                                <textarea name="description" id="newFrameColorDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newFrameColorSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateFrameColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateFrameColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Frame Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateFrameColorId" name="color_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateFrameColor">Color</label>
                                <input type="text" name="color" class="form-control" id="updateFrameColor"
                                    placeholder="Frame Color">
                            </div>

                            <div class="form-group">
                                <label for="updateFrameColorDescription">Description</label>
                                <textarea name="description" id="updateFrameColorDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateFrameColorSubmitBtn" class="btn btn-primary">Update</button>
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

            find_frame_colors();

            function find_frame_colors() {
                var path = "{{ route('admin.settings.clinics.frames.colors.index') }}";
                $('#frameColorsData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": path,
                    'responsive': true,
                    'autoWidth': false,
                    "columns": [{
                            data: 'color',
                            name: 'color'
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

            $('#newFrameColorBtn').click(function(e) {
                e.preventDefault();
                $('#newFrameColorModal').modal('show');
            });

            $('#newFrameColorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.frames.colors.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newFrameColorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newFrameColorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newFrameColorSubmitBtn').html('Save');
                        $('#newFrameColorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newFrameColorModal').modal('hide');
                            $('#newFrameColorForm')[0].reset();
                            $('#frameColorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.editFrameColor', function(e) {
                e.preventDefault();
                var color_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.frames.colors.show') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        color_id: color_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateFrameColorId').val(data['data']['id']);
                            $('#updateFrameColor').val(data['data']['color']);
                            $('#updateFrameColorDescription').val(data['data'][
                                'description'
                            ]);
                            $('#updateFrameColorModal').modal('show');
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

            $('#updateFrameColorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var color_id = $('#updateFrameColorId').val();
                let path = '{{ route('admin.settings.clinics.frames.colors.update', ':id') }}';
                path = path.replace(':id', color_id);
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
                        $('#updateFrameColorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateFrameColorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateFrameColorSubmitBtn').html('Save');
                        $('#updateFrameColorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateFrameColorModal').modal('hide');
                            $('#updateFrameColorForm')[0].reset();
                            $('#frameColorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteFrameColor', function(e) {
                e.preventDefault();
                var color_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.frames.colors.delete', ':id') }}";
                path = path.replace(':id', color_id);
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
                                    $('#frameColorsData').DataTable().ajax.reload();
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
