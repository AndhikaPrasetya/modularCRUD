<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Role";
        $breadcrumb = "Role";
        if($request->ajax()){
            $data = Role::query();
            if($search= $request->input('search.value')){
                $data->where(function($data) use ($search){
                    $data->where('name','like',"%{$search}%");
                });
            }
        
        return DataTables::eloquent($data)
        ->addIndexColumn()
        ->addColumn('Name', function($data){
            return $data->name;
        })
        ->addColumn('Guard Name', function($data){
            return $data->guard_name;
        })
        ->addColumn('action', function ($data) {
            return
                '<div class="text-center">' .
                '<a href="' . route('roles.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"> <i class="icon-pencil"></i> <span>Edit</span></a>' .
                '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="roles">' .
                '<i class="fa fa-trash-o"></i> Delete</button>' .
                '</div>';
        })
        ->rawColumns([ 'action'])
        ->make(true);
        }
        return view('roles::index', compact('title','breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Role";
        $breadcrumb = "Create Role";
        return view('roles::create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:roles',
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('name')
            ],422);
        }


        $data = Role::create([
            'name' => $request->name,
            Auth::guard('web')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'role_id' => $data->id
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
        $data = Role::find($id);
        $title = "Edit Data Role";
        $breadcrumb = "Edit Role";
        return view('roles::edit', compact('data','title','breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:roles',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('name')], 422);
        }


        $data = Role::find($id);
        $data->name = $request->name;
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => $data
        ], 200);
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
