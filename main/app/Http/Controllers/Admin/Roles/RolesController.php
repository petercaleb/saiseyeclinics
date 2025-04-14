<?php

namespace App\Http\Controllers\Admin\Roles;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\RolesRepository;
use App\Http\Requests\Admin\Roles\StoreRolesRequest;
use App\Http\Requests\Admin\Roles\UpdateRolesRequest;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    //
    private  $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->middleware('auth:admin');
        $this->rolesRepository = $rolesRepository;
    }

    public function index()
    {
        $data = $this->rolesRepository->getAllRoles();
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.main.roles.index', [
            'data' => $data,
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.main.roles.edit', [
            'permissions' => $permissions
        ]);
    }

    public function store(StoreRolesRequest $request)
    {
        $data = $request->except("_token");

        // Create the new role
        $role = Role::create([
            'name' => $data['role_name'],
            'guard_name' => 'admin'
        ]);

        // Assign selected permissions to the new role
        if ($request->has('permissions')) {
            // Fetch the permissions associated with the admin guard
            $permissions = Permission::whereIn('id', $request->input('permissions'))
                ->where('guard_name', 'admin')
                ->get();
            // Sync the selected permissions
            $role->syncPermissions($permissions);
        } else {
            $role->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'New Role Successfully created'
        ]);
    }


    public function show($id)
    {
        $role = Role::where('id', $id)
            ->where('guard_name', 'admin')
            ->firstOrFail();
        return $role;
    }

    public function edit($id)
    {
        $data = Role::where('id', $id)
            ->where('guard_name', 'admin')
            ->firstOrFail();
        $permissions = Permission::where('guard_name', 'admin')->get();
        $rolePermissions = $data->permissions->pluck('id')->toArray();
        return view('admin.main.roles.edit', [
            'data' => $data,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function update(UpdateRolesRequest $request, $id)
    {

        $data = $request->except("_token");

        $role = Role::where('id', $id)->where('guard_name', 'admin')->firstOrFail();

        // Update the role name
        $role->update([
            'name' => $data['role_name'],
        ]);

        // Assign selected permissions to the new role
        if ($request->has('permissions')) {
            // Fetch the permissions associated with the admin guard
            $permissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', 'admin')
                ->get();
            // Sync the selected permissions
            $role->syncPermissions($permissions);
        }

        return response()->json([
            'status' => true,
            'message' => 'Role Successfully updated'
        ]);
    }

    public function delete($id)
    {
        // Find the role by its ID
        $role = Role::where('id', $id)->where('guard_name', 'admin')->firstOrFail();
        // Optionally: Sync empty permissions before deleting (not strictly necessary)
        $role->syncPermissions([]);

        // Delete the role (this will automatically remove associated permissions from the role)
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role Successfully deleted'
        ]);
    }
}
