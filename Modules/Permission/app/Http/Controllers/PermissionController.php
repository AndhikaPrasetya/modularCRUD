<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Permission";
        $breadcrumb = "Permission";
        if($request->ajax()){
            $data = Permission::query();
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
                '<a href="' . route('permission.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"> <i class="icon-pencil"></i> <span>Edit</span></a>' .
                '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="permission">' .
                '<i class="fa fa-trash-o"></i> Delete</button>' .
                '</div>';
        })
        ->rawColumns([ 'action'])
        ->make(true);
        }
        return view('permission::index', compact('title','breadcrumb'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Permission";
        $breadcrumb = "Create Permission";
        return view('permission::create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
            'status'=>true,
            'message'=>'validation failed',
            'error'=>$validator->errors()->first('name')], 422);
        }

        $data = Permission::create([
            'name' => $request->name,
            Auth::guard('web')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully',
            'permission_id' => $data->id
        ], 200);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('permission::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit Permission";
        $breadcrumb = "Edit Permission";
        $data = Permission::find($id);
        return view('permission::edit', compact('title','breadcrumb','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
            'status'=>true,
            'message'=>'validation failed',
            'error'=>$validator->errors()->first('name')], 422);
        }


        $data = Permission::find($id);
        $data->name = $request->name;
        $data->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Permission::find($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully',
            ], 200);
    }
}
