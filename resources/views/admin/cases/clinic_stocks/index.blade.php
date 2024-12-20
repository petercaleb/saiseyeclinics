@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Cases
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

                <div class="col-md-3 col-sm-6 col-12">

                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="ion ion-stats-bars"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Case Stocks</span>
                            <span class="info-box-number">{{ $num_stocks }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-tools">
                                <button type="button" id="newCaseStockBtn" class="btn btn-outline-primary">
                                    <i class="fa fa-plus"></i> NEW STOCK
                                </button>
                            </div>
                        </div>
                        <!---.card-header p-0 border-bottom-0-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="casesStocksData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Case Code</th>
                                            <th>Stocks</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!--.card card-primary card-outline card-outline-tabs -->

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Frame Stocks Modal -->
        <div class="modal fade" id="newCaseStockModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Case Stock</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newCaseStockForm">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="clinic_id" value="{{ $clinic->id }}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newCaseStockCode">Code</label>
                                        <select name="case_id" id="newCaseStockCode" class="form-control select2"
                                            style="width: 100%;">
                                            <option disabled='disabled' selected="selected">
                                                Select Case Code
                                            </option>
                                            @forelse ($cases as $case)
                                                <option value="{{ $case->id }}">
                                                    {{ $case->code }} -
                                                    {{ $case->case_color->title }} -
                                                    {{ $case->case_shape->title }} -
                                                    {{ $case->case_size->title }}
                                                </option>
                                            @empty
                                                <option disabled="disabled">No Frame Code Found..</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newCaseStockStocks">
                                            Available Stocks
                                        </label>
                                        <input type="number" id="newCaseStockStocks" name="stock" class="form-control"
                                            placeholder="Enter Stocks Available" />
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newCaseStockRemarks">
                                            Remarks
                                        </label>
                                        <textarea id="newCaseStockRemarks" name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
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
                            <button type="submit" class="btn btn-primary">
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

@push('scripts')
    <script>
        $(document).ready(function() {

            find_cases_stocks();

            function find_cases_stocks() {
                var path = '{{ route('admin.frame.cases.index', $clinic->id) }}';
                $('#casesStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'stock',
                            name: 'stock'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

            $(document).on('click', '#newCaseStockBtn', function(e) {
                e.preventDefault();
                $('#newCaseStockModal').modal('show');
            });


            $('#newCaseStockForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.frame.cases.store') }}';
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
                        if(data['status'])
                        {
                            toastr.success(data['message']);
                            $('#newCaseStockForm').trigger("reset");
                            $('#newCaseStockModal').modal('hide');
                            $('#casesStocksData').DataTable().ajax.reload();
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
