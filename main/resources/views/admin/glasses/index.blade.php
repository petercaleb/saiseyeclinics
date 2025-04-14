@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sun Glasses</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Sun Glasses
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">Sun Glasses
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">Sun Glass Stocks
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--.card-header -->
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <a href="#" class="btn btn-block btn-primary newSunGlassBtn">
                                        <i class="fa fa-plus"></i> New Sun Glasses
                                    </a>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="sunGlassesData" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Brand</th>
                                                    <th>Photo</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--.tab-pane -->
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">
                                    <a href="#" class="btn btn-block btn-primary newSunGlassStockBtn">
                                        <i class="fa fa-plus"></i> Add Stock
                                    </a>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="sunGlassesStocks" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Color</th>
                                                    <th>Gender</th>
                                                    <th>Shape</th>
                                                    <th>Size</th>
                                                    <th>Opening Stock</th>
                                                    <th>Purchased Stock</th>
                                                    <th>Total Stock</th>
                                                    <th>Sold Stock</th>
                                                    <th>Closing Stock</th>
                                                    <th>Supplier Price</th>
                                                    <th>Price</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--.tab-pane -->
                            </div>
                            <!--.tab-content -->
                        </div>
                        <!--.card-body -->
                    </div>
                    <!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Sun Glasses Modal -->
        <div class="modal fade" id="newSunGlassModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Sun Glasses</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newSunGlassForm">
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="clinic_id" value="{{ $clinic->id }}" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassItemCode">Item Code </label>
                                        <input type="text" name="item_code" class="form-control" id="newSunGlassItemCode"
                                            placeholder="Enter Item Code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassBrand">Brand</label>
                                        <select id="newSunGlassBrand" name="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Brand
                                            </option>
                                            @forelse ($frame_brands as $frame_brand)
                                                <option value="{{ $frame_brand->id }}">
                                                    {{ $frame_brand->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Types Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassPhoto">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input"
                                                    id="newSunGlassPhoto" />
                                                <label class="custom-file-label" for="newSunGlassPhoto">
                                                    Choose file
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassStatus">
                                            Status
                                        </label>
                                        <select id="newSunGlassStatus" name="status" class="form-control select2"
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
                            <button type="submit" id="newSunGlassSubmitBtn" class="btn btn-primary">
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

        <div class="modal fade" id="updateSunGlassModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Sun Glasses</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateSunGlassForm">
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="glass_id" id="updateSunGlassId" />
                            <input type="hidden" name="clinic_id" value="{{ $clinic->id }}" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateSunGlassItemCode">Item Code </label>
                                        <input type="text" name="item_code" class="form-control"
                                            id="updateSunGlassItemCode" placeholder="Enter Item Code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateSunGlassBrand">Brand</label>
                                        <select id="updateSunGlassBrand" name="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Brand
                                            </option>
                                            @forelse ($frame_brands as $frame_brand)
                                                <option value="{{ $frame_brand->id }}">
                                                    {{ $frame_brand->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Types Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateSunGlassPhoto">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input"
                                                    id="updateSunGlassPhoto" />
                                                <label class="custom-file-label" for="updateSunGlassPhoto">
                                                    Choose file
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassStatus">
                                            Status
                                        </label>
                                        <select id="updateSunGlassStatus" name="status" class="form-control select2"
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
                            <button type="submit" id="updateSunGlassSubmitBtn" class="btn btn-primary">
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

        <!-- Sun Glass Stocks Modal -->
        <div class="modal fade" id="newSunGlassStockModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Sun Glass Stock</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newSunGlassStockForm">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="clinic_id" value="{{ $clinic->id }}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassStockCode">Item Code</label>
                                        <select name="glass_id" id="newSunGlassStockCode" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Item Code
                                            </option>
                                            @forelse ($glasses as $glass)
                                                <option value="{{ $glass->id }}">
                                                    {{ $glass->item_code }} - {{ $glass->frame_brand->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Item Code Found..</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockGender">
                                            Gender
                                        </label>
                                        <select id="newSunGlassStockGender" name="gender" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Gender
                                            </option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Unisex">Unisex</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-md-6 -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockColorId">
                                            Color
                                        </label>
                                        <select id="newSunGlassStockColorId" name="color_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Sun Glass Color
                                            </option>
                                            @forelse ($colors as $color)
                                                <option value="{{ $color->id }}">
                                                    {{ $color->color }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Sun Glass Colors Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockShapeId">
                                            Sun Glass Shape
                                        </label>
                                        <select id="newSunGlassStockShapeId" name="shape_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Sun Glass Shape
                                            </option>
                                            @forelse ($shapes as $shape)
                                                <option value="{{ $shape->id }}">
                                                    {{ $shape->shape }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Shapes Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockSizeId">
                                            Sun Glass Size
                                        </label>
                                        <select id="newSunGlassStockSizeId" name="size_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Choose Sun Glass Size
                                            </option>
                                            @forelse ($sizes as $size)
                                                <option value="{{ $size->id }}">
                                                    {{ $size->size }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Shapes Found</option>
                                            @endforelse
                                        </select>

                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassStockOpening">Opening Stock</label>
                                        <input type="number" id="newSunGlassStockOpening" name="opening_stock"
                                            class="form-control" placeholder="Enter Opening Stock" />
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockPrice">
                                            Price
                                        </label>
                                        <input type="text" id="newSunGlassStockPrice" name="price"
                                            class="form-control" placeholder="Enter Price" />
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newSunGlassStockSupplierPrice">
                                            Suppliers Price
                                        </label>
                                        <input type="text" id="newSunGlassStockSupplierPrice" name="supplier_price"
                                            class="form-control" placeholder="Enter Suppliers Price" />
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newSunGlassStockRemarks">
                                            Remarks
                                        </label>
                                        <textarea id="newSunGlassStockRemarks" name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="newSunGlassStockSubmitBtn" class="btn btn-primary">
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
    </section><!-- /.content -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Sun Glasses
            find_sun_glasses();

            function find_sun_glasses() {
                var path = '{{ route('admin.sun.glasses.index', $clinic->id) }}';
                $('#sunGlassesData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'item_code',
                            name: 'item_code'
                        },
                        {
                            data: 'brand',
                            name: 'brand'
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

            $(document).on('click', '.newSunGlassBtn', function(e) {
                e.preventDefault();
                $('#newSunGlassModal').modal('show');
            });

            $('#newSunGlassForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                var path = '{{ route('admin.sun.glasses.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newSunGlassSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newSunGlassSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newSunGlassSubmitBtn').html('Save');
                        $('#newSunGlassSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newSunGlassForm')[0].reset();
                            $('#newSunGlassModal').modal('hide');
                            $('#sunGlassesData').DataTable().ajax.reload();
                            $('#sunGlassesStocks').DataTable().ajax.reload();
                            location.reload();
                        }
                    },
                    error: function(data) {
                        if (error.status == 422) {
                            $.each(error.responseJSON.errors, function(i, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(error.responseJSON.message);
                        }
                    }
                });
            });

            $(document).on('click', '.updateSunGlassesBtn', function(e) {
                e.preventDefault();
                var glass_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.sun.glasses.show') }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        '_token': token,
                        'glass_id': glass_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateSunGlassModal').modal('show');
                            $('#updateSunGlassId').val(data['data']['id']);
                            $('#updateSunGlassItemCode').val(data['data']['item_code']);
                            $('#updateSunGlassBrand').val(data['data']['brand_id']);
                            $('#updateSunGlassStatus').val(data['data']['status']);
                            $('#updateSunGlassPhoto').val(data['data']['photo']);
                        }
                    },
                    error: function(error) {
                        if (error.status == 422) {
                            $.each(error.responseJSON.errors, function(i, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(error.responseJSON.message);
                        }
                    }
                });
            });

            $('#updateSunGlassForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                var path = '{{ route('admin.sun.glasses.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateSunGlassSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateSunGlassSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateSunGlassSubmitBtn').html('Update');
                        $('#updateSunGlassSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateSunGlassForm')[0].reset();
                            $('#updateSunGlassModal').modal('hide');
                            $('#sunGlassesData').DataTable().ajax.reload();
                            $('#sunGlassesStocks').DataTable().ajax.reload();
                            location.reload();
                        }
                    },
                    error: function(data) {
                        if (error.status == 422) {
                            $.each(error.responseJSON.errors, function(i, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(error.responseJSON.message);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteSunGlassesBtn', function(e) {
                e.preventDefault();
                var clinic_id = $(this).data('clinic');
                var glass_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.sun.glasses.delete') }}';
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
                                glass_id: glass_id,
                                clinic_id: clinic_id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#sunGlassesData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            // sun glasses stocks
            find_sun_glasses_stocks();

            function find_sun_glasses_stocks() {
                var path = '{{ route('admin.sun.glasses.stocks.index', $clinic->id) }}';
                $('#sunGlassesStocks').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'item_code',
                            name: 'item_code'
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'shape',
                            name: 'shape'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'opening_stock',
                            name: 'opening_stock'
                        },
                        {
                            data: 'purchase_stock',
                            name: 'purchase_stock'
                        },
                        {
                            data: 'total_stock',
                            name: 'total_stock'
                        },
                        {
                            data: 'sold_stock',
                            name: 'sold_stock'
                        },
                        {
                            data: 'closing_stock',
                            name: 'closing_stock'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'supplier_price',
                            name: 'supplier_price'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
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

            $(document).on('click', '.newSunGlassStockBtn', function(e){
                e.preventDefault();
                $('#newSunGlassStockModal').modal('show');
            });

            $('#newSunGlassStockForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.sun.glasses.stocks.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newSunGlassStockSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $('#newSunGlassStockSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newSunGlassStockSubmitBtn').html('Save');
                        $('#newSunGlassStockSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newSunGlassStockForm')[0].reset();
                            $('#newSunGlassStockModal').modal('hide');
                            $('#sunGlassesStocks').DataTable().ajax.reload();
                        }
                    },
                    error: function(error) {
                        if (error.status == 422) {
                            $.each(error.responseJSON.errors, function(i, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(error.responseJSON.message);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteStockBtn', function(e) {
                e.preventDefault();
                var stock_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.sun.glasses.stocks.delete') }}";
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
                                stock_id: stock_id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#sunGlassesStocks').DataTable().ajax.reload();
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
