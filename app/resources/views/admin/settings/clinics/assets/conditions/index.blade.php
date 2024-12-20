@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asset Conditions</h1>
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
                            Asset Conditions
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
                                <a href="#" id="newAssetConditionBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Asset Condition
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="assetConditionsData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newAssetConditionModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newAssetConditionForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Asset Condition</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="newAssetConditionTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="newAssetConditionTitle"
                                    placeholder="Asset Type Title">
                            </div>

                            <div class="form-group">
                                <label for="newAssetConditionDescription">Description</label>
                                <textarea name="description" id="newAssetConditionDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newAssetConditionSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateAssetConditionModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateAssetConditionForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Asset Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateAssetConditionId" name="type_id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="updateAssetConditionTitle">Title</label>
                                <input type="text" name="title" class="form-control" id="updateAssetConditionTitle"
                                    placeholder="Asset Condition Title">
                            </div>

                            <div class="form-group">
                                <label for="updateAssetConditionDescription">Description</label>
                                <textarea name="description" id="updateAssetConditionDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateAssetConditionSubmitBtn" class="btn btn-primary">Update</button>
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

            find_asset_conditions();

            function find_asset_conditions() {
                var path = "{{ route('admin.settings.clinics.assets.conditions.index') }}";
                $('#assetConditionsData').DataTable({
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

            $('#newAssetConditionBtn').click(function(e) {
                e.preventDefault();
                $('#newAssetConditionModal').modal('show');
                $('#newAssetConditionForm')[0].reset();
            });

            $('#newAssetConditionForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.clinics.assets.conditions.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newAssetConditionSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newAssetConditionSubmitBtn').attr('disabled', true);
                    },
                    complete:function(){
                        $('#newAssetConditionSubmitBtn').html('Save');
                        $('#newAssetConditionSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if(data['status']){
                            toastr.success(data['message']);
                            $('#newAssetConditionModal').modal('hide');
                            $('#newAssetConditionForm')[0].reset();
                            $('#assetConditionsData').DataTable().ajax.reload();

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

            $(document).on('click', '.editAssetCondition', function(e){
                e.preventDefault();
                var condition_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.settings.clinics.assets.conditions.show') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        condition_id: condition_id,
                        _token: token
                    },
                    success: function(data) {
                        if(data['status']){
                            $('#updateAssetConditionModal').modal('show');
                            $('#updateAssetConditionId').val(data['data']['id']);
                            $('#updateAssetConditionTitle').val(data['data']['title']);
                            $('#updateAssetConditionDescription').val(data['data']['description']);
                        }
                    }
                });
            });

            $('#updateAssetConditionForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                let path = '{{ route('admin.settings.clinics.assets.conditions.update', ':id') }}';
                path = path.replace(':id', $('#updateAssetConditionId').val());
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateAssetConditionSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateAssetConditionSubmitBtn').attr('disabled', true);
                    },
                    complete:function(){
                        $('#updateAssetConditionSubmitBtn').html('Update');
                        $('#updateAssetConditionSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if(data['status']){
                            toastr.success(data['message']);
                            $('#updateAssetConditionModal').modal('hide');
                            $('#updateAssetConditionForm')[0].reset();
                            $('#assetConditionsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteAssetCondition', function(e){
                e.preventDefault();
                var condition_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.settings.clinics.assets.conditions.delete', ':id') }}';
                path = path.replace(':id', condition_id);
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
                                    $('#assetConditionsData').DataTable().ajax.reload();
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
