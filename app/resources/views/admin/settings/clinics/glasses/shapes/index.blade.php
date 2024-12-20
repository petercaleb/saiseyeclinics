@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sun Glasses Shapes</h1>
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
                            Sun Glasses Shapes
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
                                <a href="#" id="newGlassShapeBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Shape
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="glassesShapesData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newGlassShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newGlassShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Sun Glass Shape</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newGlassShape">Shape</label>
                                <input type="text" name="shape" class="form-control" id="newGlassShape"
                                    placeholder="Enter Sun Glass Shape">
                            </div>

                            <div class="form-group">
                                <label for="newGlassShapeDescription">Description</label>
                                <textarea name="description" id="newGlassShapeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newGlassShapeSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateGlassShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateGlassShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Sun Glass Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateGlassShapeId" name="shape_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateGlassShape">Shape</label>
                                <input type="text" name="shape" class="form-control" id="updateGlassShape"
                                    placeholder="Frame Shape">
                            </div>

                            <div class="form-group">
                                <label for="updateGlassShapeDescription">Description</label>
                                <textarea name="description" id="updateGlassShapeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateGlassShapeSubmitBtn" class="btn btn-primary">Update</button>
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

            find_glass_shapes();

            function find_glass_shapes() {
                var path = "{{ route('admin.settings.clinics.glasses.shapes.index') }}";
                $('#glassesShapesData').DataTable({
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

            $('#newGlassShapeBtn').click(function(e) {
                e.preventDefault();
                $('#newGlassShapeModal').modal('show');
            });

            $('#newGlassShapeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.glasses.shapes.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newGlassShapeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newGlassShapeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newGlassShapeSubmitBtn').html('Save');
                        $('#newGlassShapeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newGlassShapeModal').modal('hide');
                            $('#newGlassShapeForm')[0].reset();
                            $('#glassesShapesData').DataTable().ajax.reload();
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

            $(document).on('click', '.updateGlassShapeBtn', function(e){
                e.preventDefault();
                var shape_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.glasses.shapes.show') }}";
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
                            $('#updateGlassShapeId').val(data['data']['id']);
                            $('#updateGlassShape').val(data['data']['shape']);
                            $('#updateGlassShapeDescription').val(data['data'][
                                'description'
                            ]);
                            $('#updateGlassShapeModal').modal('show');
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

            $('#updateGlassShapeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var shape_id = $('#updateGlassShapeId').val();
                let path = '{{ route('admin.settings.clinics.glasses.shapes.update', ':id') }}';
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
                        $('#updateGlassShapeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateGlassShapeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateGlassShapeSubmitBtn').html('Save');
                        $('#updateGlassShapeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateGlassShapeModal').modal('hide');
                            $('#updateGlassShapeForm')[0].reset();
                            $('#glassesShapesData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteGlassShapeBtn', function(e) {
                e.preventDefault();
                var shape_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.glasses.shapes.delete', ':id') }}";
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
                                    $('#glassesShapesData').DataTable().ajax.reload();
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
