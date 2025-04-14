@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $organization->organization }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $page_title }}
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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $organization->hq_lens()->sum('total') }}</h3>

                            <p>Lenses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newLensBtn">
                            New Lens Stock <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('admin.hq.lenses.stocks.export') }}" class="btn btn-outline-primary">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="lensData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Added</th>
                                            <th>Lens Code</th>
                                            <th>Lens Power</th>
                                            <th>Lens Type</th>
                                            <th>Lens Material</th>
                                            <th>Lens Index</th>
                                            <th>Eye</th>
                                            <th>Opening</th>
                                            <th>Purchased</th>
                                            <th>Transfered</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!--/.table-responsive -->
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.new_lens')
    @include('admin.includes.partials.modals.update_lens')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_lenses();

            function find_lenses() {
                let path = '{{ route('admin.hq.lenses.stocks.index') }}';
                $('#lensData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'date_added',
                            name: 'date_added'
                        },
                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'power',
                            name: 'power'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'material',
                            name: 'material'
                        },
                        {
                            data: 'lens_index',
                            name: 'lens_index'
                        },
                        {
                            data: 'eye',
                            name: 'eye'
                        },
                        {
                            data: 'opening',
                            name: 'opening'
                        },
                        {
                            data: 'purchased',
                            name: 'purchased'
                        },
                        {
                            data: 'transfered',
                            name: 'transfered'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "responsive": true,
                    "autoWidth": false,
                });
            }

            $(document).on('click', '.newLensBtn', function(e){
                e.preventDefault();
                $('#newLensModal').modal('show');
                $('#newLensForm').trigger("reset");
            });

            $('#newLensForm').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.lenses.stocks.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
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
                            $('#newLensModal').modal('hide');
                            $('#newLensForm')[0].reset();
                            $('#lensData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.errors);
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            });
                        }
                    },
                });

            });

            $(document).on('click', '.deleteLensBtn', function(e) {
                e.preventDefault();
                let lens_id = $(this).data('id');
                let path = '{{ route('admin.hq.lenses.stocks.delete', ':hqLens') }}';
                path = path.replace(':hqLens', lens_id)
                let token = '{{ csrf_token() }}';
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
                                _token: token
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#lensData').DataTable().clear().destroy();
                                    find_lenses();
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);

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

            $(document).on('click', '.updateLensBtn', function(e) {
                e.preventDefault();
                let lens_id = $(this).data('id');
                let path = '{{ route('admin.hq.lenses.stocks.show', ':hqLens') }}';
                path = path.replace(':hqLens', lens_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLensModal').modal('show');
                            $('#updateLensId').val(data['data']['id']);
                            $('#updateLensPower').val(data['data']['power']);
                            $('#updateLensType').val(data['data']['lens_type_id']).trigger('change');
                            $('#updateLensMaterial').val(data['data']['lens_material_id']).trigger('change');
                            $('#updateLensIndex').val(data['data']['lens_index']);
                            $('#updateLensEye').val(data['data']['eye']).trigger('change');
                        }
                    },
                });
            });

            $('#updateLensForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let lens_id = $('#updateLensId').val();
                let path = '{{ route('admin.hq.lenses.stocks.update', ':hqLens') }}';
                path = path.replace(':hqLens', lens_id);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Update');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateLensModal').modal('hide');
                            $('#updateLensForm')[0].reset();
                            $('#lensData').DataTable().clear().destroy();
                            find_lenses();
                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.errors);
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            });
                        }
                    },
                });
            });

        });
    </script>
@endpush
