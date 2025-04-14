@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Case Sizes
                    </h1>
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
                            Case Sizes
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
                                <a href="javascript:void(0)" id="newCaseSizeBtn" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Case Size
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="caseSizesData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newCaseSizeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newCaseSizeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Case Size</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newCaseSizeTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newCaseSizeTitle"
                                    placeholder="Enter Color Title">
                            </div>

                            <div class="form-group">
                                <label for="newCaseSizeDescription">Description</label>
                                <textarea name="description" id="newCaseSizeDescription" class="form-control" placeholder="Enter Color Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateCaseSizeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateCaseSizeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Case Size</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="updateCaseSizeId"
                                    placeholder="Enter Color Title">
                            </div>
                            <div class="form-group">
                                <label for="newCaseColorTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateCaseSizeTitle"
                                    placeholder="Enter Color Title">
                            </div>

                            <div class="form-group">
                                <label for="newCaseColorDescription">Description</label>
                                <textarea name="description" id="updateCaseSizeDescription" class="form-control" placeholder="Enter Color Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_case_sizes();

            function find_case_sizes() {
                var path = "{{ route('admin.settings.workshops.cases.sizes.index') }}";
                $('#caseSizesData').DataTable({
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
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }

            $(document).on('click', '#newCaseSizeBtn', function(e) {
                e.preventDefault();
                $('#newCaseSizeModal').modal('show');
                $('#newCaseSizeForm').trigger("reset");
            });

            $('#newCaseSizeForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.workshops.cases.sizes.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newCaseSizeModal').modal('hide');
                            $('#newCaseSizeForm')[0].reset();
                            $('#caseSizesData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteCaseSizeBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let color_id = $(this).data('id');
                        let path =
                            '{{ route('admin.settings.workshops.cases.sizes.delete', ':id') }}';
                        path = path.replace(':id', color_id);
                        let token = '{{ csrf_token() }}';
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                _token: token,
                                color_id: color_id,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#caseSizesData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.updateCaseSizeBtn', function(e) {
                e.preventDefault();
                let size_id = $(this).data('id');
                let path = '{{ route('admin.settings.workshops.cases.sizes.show', ':id') }}'
                path = path.replace(':id', size_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateCaseSizeModal').modal('show');
                            $('#updateCaseSizeId').val(data['data']['id']);
                            $('#updateCaseSizeTitle').val(data['data']['title']);
                            $('#updateCaseSizeDescription').val(data['data']['description']);
                        }
                    }
                });
            });

            $('#updateCaseSizeForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let size_id = $('#updateCaseSizeId').val();
                let path = '{{ route('admin.settings.workshops.cases.sizes.update', ':id') }}';
                path = path.replace(':id', size_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateCaseSizeModal').modal('hide');
                            $('#updateCaseSizeForm')[0].reset();
                            $('#caseSizesData').DataTable().ajax.reload();
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
@endpush
