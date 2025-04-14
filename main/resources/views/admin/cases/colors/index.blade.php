@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Case Colors
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
                            Case Colors
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
                                <a href="javascript:void(0)" id="newCaseColorBtn" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Case Color
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="caseColorsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newCaseColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newCaseColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Case Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newCaseColorTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newCaseColorTitle"
                                    placeholder="Enter Color Title">
                            </div>

                            <div class="form-group">
                                <label for="newCaseColorDescription">Description</label>
                                <textarea name="description" id="newCaseColorDescription" class="form-control" placeholder="Enter Color Description"></textarea>
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

        <div class="modal fade" id="updateCaseColorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateCaseColorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Case Color</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="updateCaseColorId"
                                    placeholder="Enter Color Title">
                            </div>
                            <div class="form-group">
                                <label for="newCaseColorTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateCaseColorTitle"
                                    placeholder="Enter Color Title">
                            </div>

                            <div class="form-group">
                                <label for="newCaseColorDescription">Description</label>
                                <textarea name="description" id="updateCaseColorDescription" class="form-control" placeholder="Enter Color Description"></textarea>
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

            find_case_colors();

            function find_case_colors() {
                var path = "{{ route('admin.settings.workshops.cases.color.index') }}";
                $('#caseColorsData').DataTable({
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

            $(document).on('click', '#newCaseColorBtn', function(e) {
                e.preventDefault();
                $('#newCaseColorModal').modal('show');
                $('#newCaseColorForm').trigger("reset");
            });

            $('#newCaseColorForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.workshops.cases.color.store') }}';
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
                            $('#newCaseColorModal').modal('hide');
                            $('#newCaseColorForm')[0].reset();
                            $('#caseColorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteCaseColorBtn', function(e) {
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
                            '{{ route('admin.settings.workshops.cases.color.delete', ':id') }}';
                        path = path.replace(':id', color_id);
                        let token = '{{ csrf_token() }}';
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
                                    $('#caseColorsData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.updateCaseColorBtn', function(e) {
                e.preventDefault();
                let color_id = $(this).data('id');
                let path = '{{ route('admin.settings.workshops.cases.color.show', ':id') }}'
                path = path.replace(':id', color_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateCaseColorModal').modal('show');
                            $('#updateCaseColorId').val(data['data']['id']);
                            $('#updateCaseColorTitle').val(data['data']['title']);
                            $('#updateCaseColorDescription').val(data['data']['description']);
                        }
                    }
                });
            });

            $('#updateCaseColorForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let color_id = $('#updateCaseColorId').val();
                let path = '{{ route('admin.settings.workshops.cases.color.update', ':id') }}';
                path = path.replace(':id', color_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
                            $('#updateCaseColorModal').modal('hide');
                            $('#updateCaseColorForm')[0].reset();
                            $('#caseColorsData').DataTable().ajax.reload();
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
