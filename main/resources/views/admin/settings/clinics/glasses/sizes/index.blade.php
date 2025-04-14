@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sun Glasses Sizes Settings</h1>
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
                            Sun Glasses Sizes Settings
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
                                <a href="#" id="newGlassSizeBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Size
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="glassesSizesData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Size</th>
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

        <div class="modal fade" id="newGlassSizeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newGlassSizeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Sun Glass Size</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newGlassSize">Size</label>
                                <input type="text" name="size" class="form-control" id="newGlassSize"
                                    placeholder="Enter Sun Glass Size">
                            </div>

                            <div class="form-group">
                                <label for="newGlassSizeDescription">Description</label>
                                <textarea name="description" id="newGlassSizeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newGlassSizeSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateGlassSizeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateGlassSizeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Sun Glass Size</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateGlassSizeId" name="size_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateGlassSize">Size</label>
                                <input type="text" name="size" class="form-control" id="updateGlassSize"
                                    placeholder="Sun Glass Size">
                            </div>

                            <div class="form-group">
                                <label for="updateGlassSizeDescription">Description</label>
                                <textarea name="description" id="updateGlassSizeDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateGlassSizeSubmitBtn" class="btn btn-primary">Update</button>
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

            find_glass_size();

            function find_glass_size() {
                var path = "{{ route('admin.settings.clinics.glasses.sizes.index') }}";
                $('#glassesSizesData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": path,
                    'responsive': true,
                    'autoWidth': false,
                    "columns": [{
                            data: 'size',
                            name: 'size'
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

            $('#newGlassSizeBtn').click(function(e) {
                e.preventDefault();
                $('#newGlassSizeModal').modal('show');
            });

            $('#newGlassSizeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.glasses.sizes.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newGlassSizeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newGlassSizeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newGlassSizeSubmitBtn').html('Save');
                        $('#newGlassSizeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newGlassSizeModal').modal('hide');
                            $('#newGlassSizeForm')[0].reset();
                            $('#glassesSizesData').DataTable().ajax.reload();
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

            $(document).on('click', '.updateGlassSizeBtn', function(e) {
                e.preventDefault();
                var size_id = $(this).data('id');
                var path = "{{ route('admin.settings.clinics.glasses.sizes.show') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        size_id: size_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateGlassSizeId').val(data['data']['id']);
                            $('#updateGlassSize').val(data['data']['size']);
                            $('#updateGlassSizeDescription').val(data['data'][
                                'description'
                            ]);
                            $('#updateGlassSizeModal').modal('show');
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

            $('#updateGlassSizeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var size_id = $('#updateGlassSizeId').val();
                let path = '{{ route('admin.settings.clinics.glasses.sizes.update', ':id') }}';
                path = path.replace(':id', size_id);
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
                        $('#updateGlassSizeSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateGlassSizeSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateGlassSizeSubmitBtn').html('Save');
                        $('#updateGlassSizeSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateGlassSizeModal').modal('hide');
                            $('#updateGlassSizeForm')[0].reset();
                            $('#glassesSizesData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteGlassSizeBtn', function(e) {
                e.preventDefault();
                var size_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.clinics.glasses.sizes.delete', ':id') }}";
                path = path.replace(':id', size_id);
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
                                    $('#glassesSizesData').DataTable().ajax.reload();
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
