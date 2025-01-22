<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{


    public function index(Request $request)
    {
        $title = "Data Role";
        $breadcrumb = "Role";
        if ($request->ajax()) {
            $data = Role::query();
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('name', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('Name', function ($data) {
                    return $data->name;
                })
                ->addColumn('Guard Name', function ($data) {
                    return $data->guard_name;
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission for adding/editing permissions
                    if (Auth::user()->can('update-role')) {
                        $buttons .= '<a href="' . route('roles.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Add/Edit Permission & Role</span></a>';
                    }

                    // Check permission for deleting roles
                    if (Auth::user()->can('delete-role')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="roles">' .
                            ' Delete</button>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('roles::index', compact('title', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Role";
        $breadcrumb = "Create Role";
        $permissionGroups = [
            'Role' => Permission::whereIn('name', ['create-role', 'read-role', 'update-role', 'delete-role'])->get(),
            'Permission' => Permission::whereIn('name', ['create-permission', 'read-permission', 'update-permission', 'delete-permission'])->get(),
            'User' => Permission::whereIn('name', ['create-user', 'read-user', 'update-user', 'delete-user'])->get(),
            'Document' => Permission::whereIn('name', ['create-document', 'read-document', 'update-document', 'delete-document'])->get(),
            'Category' => Permission::whereIn('name', ['create-category', 'read-category', 'update-category', 'delete-category'])->get(),
        ];
        $permissions = Permission::get();
        return view('roles::create', compact('title', 'breadcrumb', 'permissions','permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:roles',
            'permission' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('name')
            ], 422);
        }
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permission);
       
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'role_id' => $role->id
        ], 200);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('roles::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $title = "Edit Data Role";
        $breadcrumb = "Edit Role";
        $permissionGroups = [
            'Role' => Permission::whereIn('name', ['create-role', 'read-role', 'update-role', 'delete-role'])->get(),
            'Permission' => Permission::whereIn('name', ['create-permission', 'read-permission', 'update-permission', 'delete-permission'])->get(),
            'User' => Permission::whereIn('name', ['create-user', 'read-user', 'update-user', 'delete-user'])->get(),
            'Document' => Permission::whereIn('name', ['create-document', 'read-document', 'update-document', 'delete-document'])->get(),
            'Category' => Permission::whereIn('name', ['create-category', 'read-category', 'update-category', 'delete-category'])->get(),
        ];
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
        ->where('role_has_permissions.role_id', $role->id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        return view('roles::edit', compact('role', 'title', 'breadcrumb','permissions','rolePermissions','permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),  [
            'name' => ['nullable',Rule::unique('roles')->ignore($id),],
            'permission' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $data = Role::find($id);
        $data->name = $request->name;
        $data->syncPermissions($request->permission);
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => $data
        ], 200);
    }

    public function addPermission($roleId)
    {
        $title = "Edit Permission";
        $breadcrumb = "Edit Permission";
        $role = Role::find($roleId);
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        return view('roles::addPermission', compact('role', 'permissions', 'rolePermissions', 'title', 'breadcrumb'));
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $validator = Validator::make($request->all(),  [
            'permission' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('permission')
            ], 422);
        }
        $role = Role::find($roleId);
        $role->syncPermissions($request->permission);

        return response()->json([
            'success' => true,
            'message' => 'Permission added successfully',
            'data' => $role
        ], 200);
    }

    public function getDataRole(Request $request)
    {
        $search = $request->input('search');

        $role = Role::get();

        if ($search) {
            $role->where('name', 'like', "%{$search}%");
        }
        return response()->json($role);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $data = Role::find($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully',
        ], 200);
    }
}
