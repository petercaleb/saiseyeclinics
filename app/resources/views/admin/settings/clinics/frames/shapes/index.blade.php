@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frame Shapes</h1>
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
                            Frame Shapes
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
                                <a href="#" id="newFrameShapeBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Frame Shape
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="frameShapesData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Shape</th>
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

        <div class="modal fade" id="newFrameShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newFrameShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Frame Shape</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newFrameShape">Shape</label>
                                <input type="text" name="shape" class="form-control" id="newFrameShape"
                                    placeholder="Enter Frame Shape">
                            </div>

                            <div class="form-group">
                                <label for="newFrameShapeDescription">Description</label>
                                <textarea name="description" id="newFrameShapeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newFrameShapeSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateFrameShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateFrameShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Frame Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateFrameShapeId" name="shape_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateFrameShape">Shape</label>
                                <input type="text" name="shape" class="form-control" id="updateFrameShape"
                                    placeholder="Frame Shape">
                            </div>

                            <div class="form-group">
                                <label for="updateFrameShapeDescription">Description</label>
                                <textarea name="description" id="updateFrameShapeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateFrameShapeSubmitBtn" class="btn btn-primary">Update</button>
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

            find_frame_shapes();

            function find_frame_shapes() {
                var path = "{{ route('admin.settings.clinics.frames.shapes.index') }}";
                $('#frameShapesData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": path,
                    'responsive': true,
                    'autoWidth': false,
                    "columns": [{
                            data: 'shape',
                            name: 'shape'
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

            $('#newFrameShapeBtn').click(function(e) {
                e.preventDefault();
                $('#newFrameShapeModal').modal('show');
            });

            $('#newFrameShapeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.frames.shapes.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newFrameShapeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newFrameShapeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newFrameShapeSubmitBtn').html('Save');
                        $('#newFrameShapeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newFrameShapeModal').modal('hide');
                            $('#newFrameShapeForm')[0].reset();
                            $('#frameShapesData').DataTable().ajax.reload();
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

            $(document).on('click', '.editFrameShape', function(e){
                e.preventDefault();
                var shape_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.frames.shapes.show') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        shape_id: shape_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateFrameShapeId').val(data['data']['id']);
                            $('#updateFrameShape').val(data['data']['shape']);
                            $('#updateFrameShapeDescription').val(data['data'][
                                'description'
                            ]);
                            $('#updateFrameShapeModal').modal('show');
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

            $('#updateFrameShapeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var shape_id = $('#updateFrameShapeId').val();
                let path = '{{ route('admin.settings.clinics.frames.shapes.update', ':id') }}';
                path = path.replace(':id', shape_id);
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
                        $('#updateFrameShapeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateFrameShapeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateFrameShapeSubmitBtn').html('Save');
                        $('#updateFrameShapeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateFrameShapeModal').modal('hide');
                            $('#updateFrameShapeForm')[0].reset();
                            $('#frameShapesData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteFrameShape', function(e) {
                e.preventDefault();
                var shape_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.frames.shapes.delete', ':id') }}";
                path = path.replace(':id', shape_id);
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
                                    $('#frameShapesData').DataTable().ajax.reload();
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
