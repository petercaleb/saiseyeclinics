@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frames</h1>
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
                            Frames
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
                                <a href="#" id="newFrameBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Frame
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="framesData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Brand</th>
                                        <th>Size</th>
                                        <th>Type</th>
                                        <th>Material</th>
                                        <th>Photo</th>
                                        <th>Status</th>
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

        <!-- Frames Modal -->
        <div class="modal fade" id="newFrameModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Frame</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newFrameForm">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newFrameCode">Frame Code </label>
                                        <input type="text" name="code" class="form-control" id="newFrameCode"
                                            placeholder="Enter Frame Code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newFrameType">
                                            Frame Type
                                        </label>
                                        <select id="newFrameTypeId" name="type_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Type
                                            </option>
                                            @forelse ($frame_types as $frame_type)
                                                <option value="{{ $frame_type->id }}">
                                                    {{ $frame_type->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Types Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newFrameType">
                                            Frame Size
                                        </label>
                                        <select id="newFrameSizeId" name="size_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Size
                                            </option>
                                            @forelse ($frame_sizes as $size)
                                                <option value="{{ $size->id }}">
                                                    {{ $size->size }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No Frame Size found..
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newFrameMaterialId">
                                            Frame Material
                                        </label>
                                        <select id="newFrameMaterialId" name="material_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Material
                                            </option>
                                            @forelse ($frame_materials as $material)
                                                <option value="{{ $material->id }}">
                                                    {{ $material->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No Frame Materials Found..
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newFrameBrandId">
                                            Frame Brand
                                        </label>
                                        <select id="newFrameBrandId" name="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Brand
                                            </option>
                                            @forelse ($frame_brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Brand Found..</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newFramePhoto">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input"
                                                    id="newFramePhoto" />
                                                <label class="custom-file-label" for="newFramePhoto">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newFrameStatus">
                                            Frame Status
                                        </label>
                                        <select id="newFrameStatus" name="status" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Status
                                            </option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="newFrameSubmitBtn" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateFrameModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Frame</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateFrameForm">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="frame_id" id="updateFrameId" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateFrameCode">Frame Code </label>
                                        <input type="text" name="code" class="form-control" id="updateFrameCode"
                                            placeholder="Enter Frame Code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateFrameTypeId">
                                            Frame Type
                                        </label>
                                        <select id="updateFrameTypeId" name="type_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Type
                                            </option>
                                            @forelse ($frame_types as $frame_type)
                                                <option value="{{ $frame_type->id }}">
                                                    {{ $frame_type->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Types Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateFrameSizeId">
                                            Frame Size
                                        </label>
                                        <select id="updateFrameSizeId" name="size_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Size
                                            </option>
                                            @forelse ($frame_sizes as $size)
                                                <option value="{{ $size->id }}">
                                                    {{ $size->size }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No Frame Size found..
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateFrameMaterialId">
                                            Frame Material
                                        </label>
                                        <select id="updateFrameMaterialId" name="material_id"
                                            class="form-control select2" style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Material
                                            </option>
                                            @forelse ($frame_materials as $material)
                                                <option value="{{ $material->id }}">
                                                    {{ $material->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No Frame Materials Found..
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateFrameBrandId">
                                            Frame Brand
                                        </label>
                                        <select id="updateFrameBrandId" name="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Brand
                                            </option>
                                            @forelse ($frame_brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Brand Found..</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateFramePhoto">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input"
                                                    id="updateFramePhoto" />
                                                <label class="custom-file-label" for="updateFramePhoto">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateFrameStatus">
                                            Frame Status
                                        </label>
                                        <select id="updateFrameStatus" name="status" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Frame Status
                                            </option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="updateFrameSubmitBtn" class="btn btn-primary">
                                Update
                            </button>
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

@push('scripts')
    <script>
        $(document).ready(function() {

            // Frames sector (Tab)
            find_frames();

            function find_frames() {
                var path = '{{ route('admin.settings.clinics.frames.all.index') }}';
                $('#framesData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'brand',
                            name: 'brand'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'material',
                            name: 'material'
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

            $(document).on('click', '#newFrameBtn', function(e) {
                e.preventDefault();
                $('#newFrameModal').modal('show');
            });

            $('#newFrameForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.frames.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newFrameSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newFrameSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newFrameSubmitBtn').html('Save');
                        $('#newFrameSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newFrameModal').modal('hide');
                            $('#newFrameForm')[0].reset();
                            $('#framesData').DataTable().ajax.reload();
                            $('#frameStocksData').DataTable().reload();
                            location.reload();
                        }
                    },
                    error: function(error) {
                        $.each(error.responseJSON.errors, function(i, error) {
                            toastr.error(error);
                        });
                    }
                });
            });

            $(document).on('click', '.editFrame', function(e) {
                e.preventDefault();
                var frame_id = $(this).data('id');
                var path = '{{ route('admin.frames.show', ':id') }}';
                path = path.replace(':id', frame_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            $('#updateFrameModal').modal('show');
                            $('#updateFrameId').val(data['data']['id']);
                            $('#updateFrameCode').val(data['data']['code']);
                            $('#updateFrameBrandId').val(data['data']['brand_id']);
                            $('#updateFrameSizeId').val(data['data']['size']);
                            $('#updateFrameTypeId').val(data['data']['type_id']);
                            $('#updateFrameMaterialId').val(data['data']['material_id']);
                            $('#updateFramePhoto').val(data['data']['photo']);
                            $('#updateFrameStatus').val(data['data']['status']);
                        }
                    }
                });
            });

            $('#updateFrameForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var frame_id = $('#updateFrameId').val();
                var path = '{{ route('admin.frames.update', ':id') }}';
                path = path.replace(':id', frame_id);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateFrameSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateFrameSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateFrameSubmitBtn').html('Update');
                        $('#updateFrameSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateFrameModal').modal('hide');
                            $('#updateFrameForm')[0].reset();
                            $('#framesData').DataTable().ajax.reload();
                            location.reload();
                        }
                    },
                    error: function(error) {
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                        console.log(errorsHtml);
                    }
                });
                $.ajaxSetup({
                    statusCode: {
                        401: function() {
                            toastr.error("There is an error");
                        }
                    }
                });
            });

            $(document).on('click', '.deleteFrame', function(e) {
                e.preventDefault();
                let frame_id = $(this).data('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.frames.delete') }}';
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
                                frame_id: frame_id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success');
                                    $('#framesData').DataTable().ajax.reload();
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
@endpush
