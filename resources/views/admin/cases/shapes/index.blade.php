@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Case Shapes
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
                            Case Shapes
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
                                <a href="javascript:void(0)" id="newCaseShapeBtn" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Case Shape
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="caseShapesData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newCaseShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newCaseShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Case Shape</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newCaseShapeTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newCaseShapeTitle"
                                    placeholder="Enter Case Shape Title">
                            </div>

                            <div class="form-group">
                                <label for="newCaseShapeDescription">Description</label>
                                <textarea name="description" id="newCaseShapeDescription" class="form-control" placeholder="Enter Shape Description"></textarea>
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

        <div class="modal fade" id="updateCaseShapeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateCaseShapeForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Case Shape</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="updateCaseShapeId"
                                    placeholder="Enter Color Title">
                            </div>
                            <div class="form-group">
                                <label for="updateCaseShapeTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateCaseShapeTitle"
                                    placeholder="Enter Shape Title">
                            </div>

                            <div class="form-group">
                                <label for="updateCaseShapeDescription">Description</label>
                                <textarea name="description" id="updateCaseShapeDescription" class="form-control" placeholder="Enter Shape Description"></textarea>
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

            find_case_shapes();
            function find_case_shapes() {
                var path = "{{ route('admin.settings.workshops.cases.shapes.index') }}";
                $('#caseShapesData').DataTable({
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

            $(document).on('click', '#newCaseShapeBtn', function(e) {
                e.preventDefault();
                $('#newCaseShapeModal').modal('show');
                $('#newCaseShapeForm').trigger("reset");
            });

            $('#newCaseShapeForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.workshops.cases.shapes.store') }}';
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
                            $('#newCaseShapeModal').modal('hide');
                            $('#newCaseShapeForm')[0].reset();
                            $('#caseShapesData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteCaseShapeBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let shape_id = $(this).data('id');
                        let path =
                            '{{ route('admin.settings.workshops.cases.shapes.delete', ':id') }}';
                        path = path.replace(':id', shape_id);
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
                                    $('#caseShapesData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.updateCaseShapeBtn', function(e) {
                e.preventDefault();
                let shape_id = $(this).data('id');
                let path = '{{ route('admin.settings.workshops.cases.shapes.show', ':id') }}'
                path = path.replace(':id', shape_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateCaseShapeModal').modal('show');
                            $('#updateCaseShapeId').val(data['data']['id']);
                            $('#updateCaseShapeTitle').val(data['data']['title']);
                            $('#updateCaseShapeDescription').val(data['data']['description']);
                        }
                    }
                });
            });

            $('#updateCaseShapeForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let shape_id = $('#updateCaseShapeId').val();
                let path = '{{ route('admin.settings.workshops.cases.shapes.update', ':id') }}';
                path = path.replace(':id', shape_id);
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
                            $('#updateCaseShapeModal').modal('hide');
                            $('#updateCaseShapeForm')[0].reset();
                            $('#caseShapesData').DataTable().ajax.reload();
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
