<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::all();
        return view('roles::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:roles',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Role::create([
            'name' => $request->name,
            Auth::guard('web')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $data
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
        return view('roles::edit', compact('data'));
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
            return response()->json($validator->errors(), 422);
        }


        $data = Role::find($id);
        $data->name = $request->name;
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
