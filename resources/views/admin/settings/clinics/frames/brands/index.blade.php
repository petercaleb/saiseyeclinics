@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frame Brands</h1>
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
                            Frame Brands
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
                                <a href="#" id="newFrameBrandBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Brand
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="frameBrandsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newFrameBrandsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newFrameBrandsForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Frame Brand</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newFrameBrandsTitle">Brand</label>
                                <input type="text" name="title" class="form-control" id="newFrameBrandsTitle"
                                    placeholder="Brand Name">
                            </div>

                            <div class="form-group">
                                <label for="newFrameBrandsDescription">Description</label>
                                <textarea name="description" id="newFrameBrandsDescription" class="form-control" placeholder="Brand Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newFrameBrandsSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateFrameBrandsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateFrameBrandsForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Brand</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateFrameBrandsId" name="brand_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateFrameBrandsTitle">Brand</label>
                                <input type="text" name="title" class="form-control" id="updateFrameBrandsTitle"
                                    placeholder="Brand Name">
                            </div>

                            <div class="form-group">
                                <label for="updateFrameBrandsDescription">Description</label>
                                <textarea name="description" id="updateFrameBrandsDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateFrameBrandsSubmitBtn" class="btn btn-primary">Update</button>
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
    $(document).ready(function(){

        find_frame_brands();
        function find_frame_brands() {
            var path = "{{ route('admin.settings.clinics.frames.brands.index') }}";
            $('#frameBrandsData').DataTable({
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

        $('#newFrameBrandBtn').click(function(e) {
            e.preventDefault();
            $('#newFrameBrandsModal').modal('show');
        });

        $('#newFrameBrandsForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var path = '{{ route('admin.settings.clinics.frames.brands.store') }}';
            $.ajax({
                url: path,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#newFrameBrandsSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#newFrameBrandsSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#newFrameBrandsSubmitBtn').html('Save');
                    $('#newFrameBrandsSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        $('#newFrameBrandsModal').modal('hide');
                        $('#newFrameBrandsForm')[0].reset();
                        $('#frameBrandsData').DataTable().ajax.reload();
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

        $(document).on('click', '.editFrameBrand', function(e) {
            e.preventDefault();
            var brand_id = $(this).data('id');
            var path = "{{ route('admin.settings.clinics.frames.brands.show') }}";
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    brand_id: brand_id,
                    _token: token
                },
                dataType: "json",
                success: function(data) {
                    if (data['status']) {
                        $('#updateFrameBrandsId').val(data['data']['id']);
                        $('#updateFrameBrandsTitle').val(data['data']['title']);
                        $('#updateFrameBrandsDescription').val(data['data']['description']);
                        $('#updateFrameBrandsModal').modal('show');
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

        $('#updateFrameBrandsForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var brand_id = $('#updateFrameBrandsId').val();
            let path = '{{ route('admin.settings.clinics.frames.brands.update', ':id') }}';
            path = path.replace(':id', brand_id);
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
                    $('#updateFrameBrandsSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                    $('#updateFrameBrandsSubmitBtn').attr('disabled', true);
                },
                complete: function() {
                    $('#updateFrameBrandsSubmitBtn').html('Save');
                    $('#updateFrameBrandsSubmitBtn').attr('disabled', false);
                },
                success: function(data) {
                    if (data['status']) {
                        toastr.success(data['message']);
                        $('#updateFrameBrandsModal').modal('hide');
                        $('#updateFrameBrandsForm')[0].reset();
                        $('#frameBrandsData').DataTable().ajax.reload();
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

        $(document).on('click', '.deleteFrameBrand', function(e){
            e.preventDefault();
            var brand_id = $(this).data('id');
            var token = "{{ csrf_token() }}";
            var path = "{{ route('admin.settings.clinics.frames.brands.delete', ':id') }}";
            path = path.replace(':id', brand_id);
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
                                $('#frameBrandsData').DataTable().ajax.reload();
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
