@extends('admin.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sun Glasses Colors</h1>
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
                            Sun Glasses Colors
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
                                <a href="#" id="newGlassColorBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Color
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="sunGlassesColorsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newGlassColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newGlassColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Glass Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newGlassColor">Color</label>
                                <input type="text" name="color" class="form-control" id="newGlassColor"
                                    placeholder="Enter Sun Glass Color">
                            </div>

                            <div class="form-group">
                                <label for="newGlassColorDescription">Description</label>
                                <textarea name="description" id="newGlassColorDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newGlassColorSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateGlassColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateGlassColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Sun Glass Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateGlassColorId" name="color_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateGlassColor">Color</label>
                                <input type="text" name="color" class="form-control" id="updateGlassColor"
                                    placeholder="Sun Glass Color">
                            </div>

                            <div class="form-group">
                                <label for="updateGlassColorDescription">Description</label>
                                <textarea name="description" id="updateGlassColorDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateGlassColorSubmitBtn" class="btn btn-primary">Update</button>
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

            find_glass_colors();

            function find_glass_colors() {
                var path = "{{ route('admin.settings.clinics.glasses.colors.index') }}";
                $('#sunGlassesColorsData').DataTable({
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

            $('#newGlassColorBtn').click(function(e) {
                e.preventDefault();
                $('#newGlassColorModal').modal('show');
            });

            $('#newGlassColorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.glasses.colors.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newGlassColorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newGlassColorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newGlassColorSubmitBtn').html('Save');
                        $('#newGlassColorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newGlassColorModal').modal('hide');
                            $('#newGlassColorForm')[0].reset();
                            $('#sunGlassesColorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.updateGlassColorBtn', function(e) {
                e.preventDefault();
                var color_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.glasses.colors.show') }}";
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
                            $('#updateGlassColorId').val(data['data']['id']);
                            $('#updateGlassColor').val(data['data']['color']);
                            $('#updateGlassColorDescription').val(data['data'][
                                'description'
                            ]);
                            $('#updateGlassColorModal').modal('show');
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

            $('#updateGlassColorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var color_id = $('#updateGlassColorId').val();
                let path = '{{ route('admin.settings.clinics.glasses.colors.update', ':id') }}';
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
                        $('#updateGlassColorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateGlassColorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateGlassColorSubmitBtn').html('Save');
                        $('#updateGlassColorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateGlassColorModal').modal('hide');
                            $('#updateGlassColorForm')[0].reset();
                            $('#sunGlassesColorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteGlassColorBtn', function(e) {
                e.preventDefault();
                var color_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.glasses.colors.delete', ':id') }}";
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
                                    $('#sunGlassesColorsData').DataTable().ajax.reload();
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
