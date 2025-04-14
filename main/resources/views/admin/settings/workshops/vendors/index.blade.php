@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vendors</h1>
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
                            Vendors
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
                                <a href="#" id="newVendorBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Vendor
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="vendorsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Full Names</th>
                                        <th>Company</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Location</th>
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

        <div class="modal fade" id="newVendorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newVendorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">New Vendor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newVendorFirstName">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="newVendorFirstName"
                                            placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newVendorLastName">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" id="newVendorLastName"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newVendorCompany">Company Name</label>
                                        <input type="text" name="company" class="form-control" id="newVendorCompany"
                                            placeholder="Company Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newVendorPhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="newVendorPhone"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newVendorEmail">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="newVendorEmail"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="newVendorType">Vendor Type</label>
                                    <select id="newVendorType" name="type" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected" disabled="disabled">Choose Type</option>
                                        <option value="Local">Local</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newVendorLocation">Location</label>
                                        <input type="text" name="location" class="form-control" id="newVendorLocation"
                                            placeholder="Location">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newVendorSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateVendorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateVendorForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Vendor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" id="updateVendorId" name="vendor_id"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateVendorFirstName">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            id="updateVendorFirstName" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateVendorLastName">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            id="updateVendorLastName" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateVendorCompany">Company Name</label>
                                        <input type="text" name="company" class="form-control"
                                            id="updateVendorCompany" placeholder="Company Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateVendorPhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="updateVendorPhone"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateVendorEmail">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="updateVendorEmail"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="updateVendorType">Vendor Type</label>
                                    <select id="updateVendorType" name="type" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected" disabled="disabled">Choose Type</option>
                                        <option value="Local">Local</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateVendorLocation">Location</label>
                                        <input type="text" name="location" class="form-control"
                                            id="updateVendorLocation" placeholder="Location">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateVendorSubmitBtn" class="btn btn-primary">Update</button>
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

            find_vendors();

            function find_vendors() {
                var path = '{{ route('admin.settings.workshops.vendors.index') }}';
                $('#vendorsData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": path,
                    'responsive': true,
                    'autoWidth': false,
                    "columns": [{
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'company',
                            name: 'company'
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
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'location',
                            name: 'location'
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

            $('#newVendorBtn').click(function(e) {
                e.preventDefault();
                $('#newVendorModal').modal('show');
                $('#newVendorForm')[0].reset();
            });

            $('#newVendorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.settings.workshops.vendors.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('#newVendorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newVendorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newVendorSubmitBtn').html('Save');
                        $('#newVendorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newVendorModal').modal('hide');
                            $('#newVendorForm')[0].reset();
                            $('#vendorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.updateVendorBtn', function(e) {
                e.preventDefault();
                var vendor_id = $(this).data('id');
                var path = "{{ route('admin.settings.workshops.vendors.show') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        vendor_id: vendor_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateVendorModal').modal('show');
                            $('#updateVendorId').val(data['data']['id']);
                            $('#updateVendorFirstName').val(data['data']['first_name']);
                            $('#updateVendorLastName').val(data['data']['last_name']);
                            $('#updateVendorCompany').val(data['data']['company']);
                            $('#updateVendorPhone').val(data['data']['phone']);
                            $('#updateVendorEmail').val(data['data']['email']);
                            $('#updateVendorLocation').val(data['data']['location']);
                        }
                    }
                });

            });

            $('#updateVendorForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var vendor_id = $('#updateVendorId').val();
                let path = '{{ route('admin.settings.workshops.vendors.update', ':id') }}';
                path = path.replace(':id', vendor_id);
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
                        $('#updateVendorSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateVendorSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateVendorSubmitBtn').html('Update');
                        $('#updateVendorSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateVendorModal').modal('hide');
                            $('#updateVendorForm')[0].reset();
                            $('#vendorsData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteVendorBtn', function(e){
                e.preventDefault();
                var vendor_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = "{{ route('admin.settings.workshops.vendors.delete', ':id') }}";
                path = path.replace(':id', vendor_id);
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
                                    $('#vendorsData').DataTable().ajax.reload();
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
