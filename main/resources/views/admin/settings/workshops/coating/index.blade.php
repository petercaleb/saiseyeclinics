@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lens Coating</h1>
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
                            Lens Coating
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
                                <a href="#" id="newLensCoatingBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Lens Coating
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="coatingData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newLensCoatingModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newLensCoatingForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Lens Coating</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newLensCoatingTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newLensCoatingTitle"
                                    placeholder="Lens Coating Title">
                            </div>

                            <div class="form-group">
                                <label for="newLensCoatingDescription">Description</label>
                                <textarea name="description" id="newLensCoatingDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newLensCoatingSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateLensCoatingModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateLensCoatingForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Lens Coating</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateLensCoatingId" name="coating_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateLensCoatingTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateLensCoatingTitle"
                                    placeholder="Lens Coating Title">
                            </div>

                            <div class="form-group">
                                <label for="updateLensCoatingDescription">Description</label>
                                <textarea name="description" id="updateLensCoatingDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateLensCoatingSubmitBtn" class="btn btn-primary">Update</button>
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

            find_coating();

            function find_coating() {
                var path = "{{ route('admin.settings.workshops.coating.index') }}";
                $('#coatingData').DataTable({
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

            $('#newLensCoatingBtn').click(function(e) {
                e.preventDefault();
                $('#newLensCoatingModal').modal('show');
                $('#newLensCoatingForm')[0].reset();
            });

            $('#newLensCoatingForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.workshops.coating.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newLensCoatingSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newLensCoatingSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newLensCoatingSubmitBtn').html('Save');
                        $('#newLensCoatingSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensCoatingModal').modal('hide');
                            $('#newLensCoatingForm')[0].reset();
                            $('#coatingData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteCoatingBtn', function(e){
                e.preventDefault();
                var coating_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.workshops.coating.delete', ':id') }}";
                path = path.replace(':id', coating_id);
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
                                    $('#coatingData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.updateCoatingBtn', function(e) {
                e.preventDefault();
                var coating_id = $(this).data('id');
                var path = "{{ route('admin.settings.workshops.coating.show', ':id') }}";
                path = path.replace(':id', coating_id);
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLensCoatingModal').modal('show');
                            $('#updateLensCoatingId').val(data['data']['id']);
                            $('#updateLensCoatingTitle').val(data['data']['title']);
                            $('#updateLensCoatingDescription').val(data['data']['description']);
                            
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

            $('#updateLensCoatingForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var coating_id = $('#updateLensCoatingId').val();
                let path = '{{ route('admin.settings.workshops.coating.update', ':id') }}';
                path = path.replace(':id', coating_id);
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
                        $('#updateLensCoatingSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateLensCoatingSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateLensCoatingSubmitBtn').html('Update');
                        $('#updateLensCoatingSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateLensCoatingModal').modal('hide');
                            $('#updateLensCoatingForm')[0].reset();
                            $('#coatingData').DataTable().ajax.reload();
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

        });
    </script>
@endsection
