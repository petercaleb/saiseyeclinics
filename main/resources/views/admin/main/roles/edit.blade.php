@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.partials.main.breadcrumbs')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <form @isset($data) id="updateRoleForm" @else id="newRoleForm" @endisset>
                            <div class="card-body">
                                @csrf
                                @isset($data)
                                    @method('PUT')
                                @endisset
                                <div class="form-group">
                                    <label for="newRoleName">Role Name</label>
                                    <input type="text" name="role_name"
                                        value="@isset($data) {{ $data->name }} @endisset"
                                        class="form-control" id="newRoleName" placeholder="New Role">
                                </div>
                                <div class="form-group">
                                    <label>Permissions</label>
                                    @foreach ($permissions as $permission)
                                        @isset($data)
                                            <div class="form-check">
                                                <input class="form-check-input" id="permission-{{ $permission->id }}"
                                                    type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" id="permission-{{ $permission->id }}"
                                                    type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endisset
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    @isset($data)
                                        Update Role
                                    @else
                                        Create Role
                                    @endisset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#newRoleForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.roles.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html(
                            'Create Role'
                        );
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newRoleForm').trigger("reset");
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('admin.roles.index') }}";
                            }, 1000);
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
            @isset($data)
                $('#updateRoleForm').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(form[0]);
                    let path = '{{ route('admin.roles.update', $data->id) }}';
                    $.ajax({
                        type: "POST",
                        url: path,
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            form.find('button[type=submit]').html(
                                '<i class="fa fa-spinner fa-spin"></i>'
                            );
                            form.find('button[type=submit]').attr('disabled', true);
                        },
                        complete: function() {
                            form.find('button[type=submit]').html(
                                'Update Role'
                            );
                            form.find('button[type=submit]').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#updateRoleForm').trigger("reset");
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('admin.roles.index') }}";
                                }, 1000);
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
            @endisset
        });
    </script>
@endpush
