@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.partials.main.breadcrumbs')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-outline-primary">
                                    New Role
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge badge-info">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $role->created_at }}</td>
                                            <td class="col-2">
                                                @if ($role->name !== 'super-admin')
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        Edit
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-danger btn-sm deleteRoleBtn" data-id="{{ $role->id }}">
                                                        Delete
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row -->
        </div>
        <!--/.container-fluid -->

        <div class="modal fade" id="updateRoleModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Role
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateRoleForm">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="updateRoleName">Role Name</label>
                                        <input type="text" name="role_name" class="form-control" id="updateRoleName"
                                            placeholder="New Role">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @foreach ($permissions as $permission)
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" id="permission-{{ $permission->id }}"
                                                    type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!--/.content -->
@endsection

@push('scripts')
    @include('admin.main.roles.scripts')
@endpush
