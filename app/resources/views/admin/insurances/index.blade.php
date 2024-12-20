@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Insurance Companies</h1>
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
                        <li class="breadcrumb-item active">Insurance Companies</li>
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
                                <a href="#" id="newInsuranceBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Insurance Company
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="insuranceData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
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

        <div class="modal fade" id="newInsuranceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newInsuranceForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">New Insurance Company</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newInsuranceTitle">Company Name</label>
                                        <input type="text" name="title" class="form-control" id="newInsuranceTitle"
                                            placeholder="Enter Company Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newInsurancePhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="newInsurancePhone"
                                            placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newInsuranceEmail">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="newInsuranceEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newInsuranceAddress">Address</label>
                                        <input type="text" name="address" class="form-control" id="newInsuranceAddress"
                                            placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newInsuranceDescription">Description</label>
                                        <textarea name="description" class="form-control" id="newInsuranceDescription" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newInsuranceSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateInsuranceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateInsuranceForm">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Update Insurance Company</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="insurance_id" class="form-control" id="updateInsuranceId">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateInsuranceTitle">Company Name</label>
                                        <input type="text" name="title" class="form-control" id="updateInsuranceTitle"
                                            placeholder="Enter Company Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateInsurancePhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="updateInsurancePhone"
                                            placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateInsuranceEmail">Email Address</label>
                                        <input type="text" name="email" class="form-control" id="updateInsuranceEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateInsuranceAddress">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="updateInsuranceAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateInsuranceDescription">Description</label>
                                        <textarea name="description" class="form-control" id="updateInsuranceDescription" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateInsuranceSubmitBtn" class="btn btn-primary">Update</button>
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

            find_insurance();

            function find_insurance() {
                var path = '{{ route('admin.insurance.index') }}';
                $('#insuranceData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'address',
                            name: 'address'
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
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('#newInsuranceBtn').click(function(e) {
                e.preventDefault();
                $('#newInsuranceModal').modal('show');
                $('#newStatusForm')[0].reset();
            });

            $('#newInsuranceForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.insurance.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newInsuranceSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newInsuranceSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newInsuranceSubmitBtn').html('Save');
                        $('#newInsuranceSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newInsuranceModal').modal('hide');
                            $('#newInsuranceForm')[0].reset();
                            $('#insuranceData').DataTable().ajax.reload();
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

            $(document).on('click', '.editBtn', function(e){
                e.preventDefault();
                var insurance_id = $(this).attr('data-id');
                var path = '{{ route('admin.insurance.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        insurance_id: insurance_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#updateInsuranceModal').modal('show');
                            $('#updateInsuranceId').val(data['data']['id']);
                            $('#updateInsuranceTitle').val(data['data']['title']);
                            $('#updateInsurancePhone').val(data['data']['phone']);
                            $('#updateInsuranceEmail').val(data['data']['email']);
                            $('#updateInsuranceAddress').val(data['data']['address']);
                            $('#updateInsuranceDescription').val(data['data']['description']);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $('#updateInsuranceForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.insurance.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateInsuranceSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateInsuranceSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateInsuranceSubmitBtn').html('Save');
                        $('#updateInsuranceSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateInsuranceModal').modal('hide');
                            $('#updateInsuranceForm')[0].reset();
                            $('#insuranceData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

        });
    </script>
@endsection
