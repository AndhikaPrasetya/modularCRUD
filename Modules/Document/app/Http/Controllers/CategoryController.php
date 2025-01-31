<?php

namespace Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Document\Models\DocumentCategories;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Category";
        $breadcrumb = "Category";
        if ($request->ajax()) {
            $data = DocumentCategories::query();
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
                ->addColumn('Deskripsi', function ($data) {
                    return $data->description;
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Auth::user()->can('update-category')) {
                        $buttons .= '<a href="' . route('category.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Auth::user()->can('delete-category')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="category">' .
                            ' Delete</button>';
                    }
                    

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('document::CategoryView.index', compact('title', 'breadcrumb'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Category";
        $breadcrumb = "Create Category";
        return view('document::CategoryView.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('name')
            ], 422);
        }
        
        $category = new DocumentCategories();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'category created successfully',
            'category_id' => $category->id
        ], 200);
    }
    

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('document::CategoryView.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = DocumentCategories::find($id);
        $title = "Edit Data Category";
        $breadcrumb = "Edit Category";
        return view('document::CategoryView.edit', compact('category','title','breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()->first('name')
            ], 422);
        }

        $category = DocumentCategories::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DocumentCategories::find($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
