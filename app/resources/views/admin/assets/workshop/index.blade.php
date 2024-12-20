@extends('admin.layouts.workshop')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Assets
                    </h1>
                    <small>{{ $workshop->name }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Assets
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
                                <a href="#" id="newAssetBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Asset
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="assetsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Asset</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Serial</th>
                                        <th>Condition</th>
                                        <th>Quantity</th>
                                        <th>Purchase Date</th>
                                        <th>Cost</th>
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

        <div class="modal fade" id="newAssetModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Asset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newAssetForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="workshop_id" class="form-control"
                                            value="{{ $workshop->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="newAssetTitle">Asset</label>
                                        <input type="text" name="asset" class="form-control" id="newAssetTitle"
                                            placeholder="Enter asset name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newAssetSerial">Serial</label>
                                        <input type="text" name="serial_number" class="form-control" id="newAssetSerial"
                                            placeholder="Enter Serial Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newAssetType">Asset Type</label>
                                        <select id="newAssetType" name="type_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Asset Type
                                            </option>
                                            @forelse ($asset_types as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No asset types found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newAssetCondition">Asset Condition</label>
                                        <select id="newAssetCondition" name="condition_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Asset Condition
                                            </option>
                                            @forelse ($asset_conditions as $condition)
                                                <option value="{{ $condition->id }}">
                                                    {{ $condition->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No asset conditions found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newAssetQuantity">Quantity</label>
                                        <input type="text" name="quantity" class="form-control" id="newAssetQuantity"
                                            placeholder="Enter Quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newAssetDescription">Description</label>
                                        <textarea name="description" id="newAssetDescription" class="form-control" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newAssetPurchaseDate">Purchase Date</label>
                                        <input type="text" name="purchase_date" class="form-control datepicker"
                                            id="newAssetPurchaseDate" placeholder="Enter Purchase Date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newAssetPurchaseCost">Purchase Cost</label>
                                        <input type="text" name="purchase_cost" class="form-control"
                                            id="newAssetPurchaseCost" placeholder="Enter Purchase Cost">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newAssetSubmitBtn" class="btn btn-primary">
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

        <div class="modal fade" id="updateAssetModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Asset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateAssetForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" id="updateAssetId" name="asset_id" class="form-control">
                                        <input type="hidden" name="workshop_id" class="form-control"
                                            value="{{ $workshop->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="updateAssetTitle">Asset</label>
                                        <input type="text" name="asset" class="form-control" id="updateAssetTitle"
                                            placeholder="Enter asset name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateAssetSerial">Serial</label>
                                        <input type="text" name="serial_number" class="form-control"
                                            id="updateAssetSerial" placeholder="Enter Serial Number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateAssetType">Asset Type</label>
                                        <select id="updateAssetType" name="type_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Asset Type
                                            </option>
                                            @forelse ($asset_types as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No asset types found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateAssetCondition">Asset Condition</label>
                                        <select id="updateAssetCondition" name="condition_id"
                                            class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Asset Condition
                                            </option>
                                            @forelse ($asset_conditions as $condition)
                                                <option value="{{ $condition->id }}">
                                                    {{ $condition->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No asset conditions found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateAssetQuantity">Quantity</label>
                                        <input type="text" name="quantity" class="form-control"
                                            id="updateAssetQuantity" placeholder="Enter Quantity">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateAssetDescription">Description</label>
                                        <textarea name="description" id="updateAssetDescription" class="form-control" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateAssetPurchaseDate">Purchase Date</label>
                                        <input type="text" name="purchase_date" class="form-control datepicker"
                                            id="updateAssetPurchaseDate" placeholder="Enter Purchase Date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateAssetPurchaseCost">Purchase Cost</label>
                                        <input type="text" name="purchase_cost" class="form-control"
                                            id="updateAssetPurchaseCost" placeholder="Enter Purchase Cost">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateAssetSubmitBtn" class="btn btn-primary">
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

        <div class="modal fade" id="transferAssetModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tranfer Asset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="transferAssetForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" id="transferAssetId" name="asset_id" class="form-control">
                                        <input type="hidden" name="from_workshop_id" class="form-control"
                                            value="{{ $workshop->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="transferAssetTo">Transfer To</label>
                                        <select id="transferAssetTo" name="to_workshop_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Workshop asset transfered to
                                            </option>
                                            @forelse ($org_workshops as $org_workshop)
                                                <option value="{{ $org_workshop->id }}">
                                                    {{ $org_workshop->name }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No Any other Workshop found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <!--.col-md-12-->
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="utransferAssetCondition">Asset Condition</label>
                                        <select id="transferAssetCondition" name="condition_id"
                                            class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled="disabled">
                                                Choose Asset Condition
                                            </option>
                                            @forelse ($asset_conditions as $condition)
                                                <option value="{{ $condition->id }}">
                                                    {{ $condition->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">
                                                    No asset conditions found!
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!--.col-md-6-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transferAssetDate">Transfer Date</label>
                                        <input type="text" id="transferAssetDate" name="transfer_date"
                                            class="form-control datepicker" placeholder="Transfer Date">
                                    </div>
                                </div>
                                <!--.col-md-6-->
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="transferAssetQuantity">Quantity</label>
                                        <input type="number" id="transferAssetQuantity" name="quantity"
                                            class="form-control" placeholder="Enter Quantity Transfered" />
                                    </div>
                                </div>
                                <!--.col-md-12-->
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="transferAssetRemarks">Remarks</label>
                                        <textarea name="remarks" id="transferAssetRemarks" class="form-control" placeholder="Remarks"></textarea>
                                    </div>
                                </div>
                                <!--.col-md-12-->
                            </div>
                            <!--.row-->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="transferAssetSubmitBtn" class="btn btn-primary">
                                Transfer
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

@section('scripts')
    <script>
        $(document).ready(function() {

            find_assets();

            function find_assets() {
                var path = '{{ route('admin.workshop.assets.index', $workshop->id) }}';
                $('#assetsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'asset',
                            name: 'asset'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'purchase_date',
                            name: 'purchase_date'
                        },
                        {
                            data: 'purchase_cost',
                            name: 'purchase_cost'
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

            $(document).on('click', '#newAssetBtn', function(e) {
                e.preventDefault();
                $('#newAssetModal').modal('show');
            });

            $('#newAssetForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.workshop.assets.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newAssetSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newAssetSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newAssetSubmitBtn').html('Save');
                        $('#newAssetSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newAssetForm')[0].reset();
                            $('#newAssetModal').modal('hide');
                            $('#assetsData').DataTable().ajax.reload();
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

            $(document).on('click', '.updateItemBtn', function(e){
                e.preventDefault();
                let asset_id = $(this).data('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.workshop.assets.show') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        asset_id:asset_id,
                        _token:token
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data['status']) {
                            $('#updateAssetModal').modal('show');
                            $('#updateAssetId').val(data['data']['id']);
                            $('#updateAssetTitle').val(data['data']['asset']);
                            $('#updateAssetSerial').val(data['data']['serial_number']);
                            $('#updateAssetQuantity').val(data['data']['quantity']);
                            $('#updateAssetDescription').val(data['data']['description']);
                            $('#updateAssetPurchaseDate').val(data['data']['purchase_date']);
                            $('#updateAssetPurchaseCost').val(data['data']['purchase_cost']);
                        }
                        
                    }
                });
            });

            $('#updateAssetForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                let path = '{{ route('admin.workshop.assets.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateAssetSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateAssetSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateAssetSubmitBtn').html('Update');
                        $('#updateAssetSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateAssetForm')[0].reset();
                            $('#updateAssetModal').modal('hide');
                            $('#assetsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteItemBtn', function(e) {
                e.preventDefault();
                var asset_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.workshop.assets.delete') }}';
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
                            type: 'DELETE',
                            data: {
                                asset_id: asset_id,
                                _token: token
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#assetsData').DataTable().ajax.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON;
                                var errorsHtml = '<ul>';
                                $.each(errors['errors'], function(key, value) {
                                    errorsHtml += '<li>' + value + '</li>';
                                });
                                errorsHtml += '</ul>';
                                Swal.fire(errorsHtml, '', 'info');
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.transferItemBtn', function(e){
                e.preventDefault();
                var asset_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.workshop.assets.show') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        asset_id: asset_id,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            $('#transferAssetId').val(data['data']['id']);
                            $('#transferAssetModal').modal('show');
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

            $('#transferAssetForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                let path = '{{ route('admin.workshop.assets.transfer.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#transferAssetSubmitBtn').html(
                        '<i class="fa fa-spinner fa-spin"></i>');
                        $('#transferAssetSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#transferAssetSubmitBtn').html('Transfer');
                        $('#transferAssetSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#transferAssetForm')[0].reset();
                            $('#transferAssetModal').modal('hide');
                            $('#assetsData').DataTable().ajax.reload();
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
