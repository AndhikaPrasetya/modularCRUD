<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Users";
        $breadcrumb = "Users";
        if ($request->ajax()) {
            $data = User::query();
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('role', function ($data) {
                    $roles = $data->getRoleNames();
                    $rolesList = '';

                    foreach ($roles as $role) {
                        $rolesList .= '<span class="badge badge-primary">' . $role . '</span> ';
                    }

                    return $rolesList;
                })
                ->addColumn('action', function ($data) {
                    return
                        '<div class="text-center">' .
                        '<a href="' . route('users.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1" > <i class="icon-pencil"></i> <span>Edit</span></a>' .
                        '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="users">' .
                        '<i class="fa fa-trash-o"></i> Delete</button>' .
                        '</div>';
                })
                ->rawColumns(['action', 'role'])
                ->make(true);
        }
        return view('user::index', compact('title', 'breadcrumb'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Data Users";
        $breadcrumb = "Create Users";
        $roles = Role::pluck('name', 'name')->all();
        return view('user::create', compact('title', 'breadcrumb', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'roles' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:3000',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $image = $request->file('image');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('foto-profile', $fileName, 'public'); // Simpan file di storage

        $data =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'storage/foto-profile/' . $fileName,
        ]);

        if (!empty($request->roles)) {
            $data->syncRoles($request->roles);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $data->id,

        ], 200);
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit Data Users";
        $breadcrumb = "Edit Users";
        $data = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $data->roles->pluck('name', 'name')->all();

        return view('user::edit', compact('data', 'title', 'breadcrumb', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'roles' => 'required|array',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:3000'
        ]);
        $user = User::find($id);

        if ($request->hasFile('image')) {
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }
    
            // Upload file baru
            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('foto-profile', $fileName, 'public');
            $user->image = 'storage/foto-profile/' . $fileName;
        }

        $user->name = $request->name;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update email jika diisi
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        // Update role
        $user->syncRoles($request->roles);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }
}
