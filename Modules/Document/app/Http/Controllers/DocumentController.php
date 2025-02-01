<?php

namespace Modules\Document\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Document\Models\Document;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\Document\Models\DocumentCategories;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Category";
        $breadcrumb = "Category";
        if ($request->ajax()) {
            $data = Document::with(['category', 'user']);
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('file_name', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('file_name', function ($data) {
                    return $data->file_name;
                })
                ->addColumn('Category id', function ($data) {
                    return $data->category->name;
                })
                ->addColumn('Deskripsi', function ($data) {
                    return $data->description;
                })
                ->addColumn('status', function ($data) {
                    return $data->description;
                })
                ->addColumn('uploaded_by', function ($data) {
                    return $data->user ? $data->user->name : '';
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Auth::user()->can('update-document')) {
                        $buttons .= '<a href="' . route('document.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Auth::user()->can('delete-document')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="category">' .
                            ' Delete</button>';
                    }
                    

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('document::DocumentView.index', compact('title', 'breadcrumb'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Category";
        $breadcrumb = "Create";
        $category = DocumentCategories::all();
        $documentStatus =['active','expired'] ;
        return view('document::DocumentView.create',compact('category','title','documentStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'file_path' => 'required|array',  // Tambahkan rule array
            'file_path.*' => 'mimes:pdf,xlx,csv|max:2048',
            'description' => 'nullable',
            'status' => 'required',
            'valid_from' => 'required',
            'valid_until' => 'required',
            'category_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $fileData = [];
            if ($request->hasFile('file_path')) {  
                foreach ($request->file('file_path') as $file) {  
                    $fileName = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('document', $fileName, 'public');
                    $fileData[] = 'storage/document/' . $fileName;
                }
            }
    
            $document = new Document();
            $document->file_name = $request->file_name;
            $document->file_path = json_encode($fileData);
            $document->description = $request->description;
            $document->status = $request->status;
            $document->valid_from = $request->valid_from;
            $document->valid_until = $request->valid_until;
            $document->category_id = $request->category_id;
            $document->uploaded_by = Auth::id();
            $document->save();
    
            Log::debug('Document created: ', [
                'document_id' => $document->id,
                'status' => $document->status,
                'file_path' => $document->file_path,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Document Created Successfully',
                'document_id' => $document->id
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Error creating document: ', ['error' => $e->getMessage()]);
            foreach ($fileData as $file) {
                if (Storage::exists('public/' . $file)) {
                    Storage::delete('public/' . $file);
                }
            }
    
            return response()->json([
                'status' => false,
                'error' => 'An error occurred while creating the document.'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('document::DocumentView.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Create Category";
        $breadcrumb = "Create";
        $document = Document::find($id);
        $category = DocumentCategories::all();
        $documentStatus =['active','expired'] ;
        return view('document::DocumentView.edit', compact('title','breadcrumb','document','category','documentStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'file_name' => 'required',
        'file_path.*' => 'nullable|mimes:pdf,xlsx,csv|max:2048',
        'description' => 'nullable',
        'status' => 'required',
        'valid_from' => 'required',
        'valid_until' => 'required',
        'category_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $document = Document::find($id);
        if (!$document) {
            return response()->json([
                'status' => false,
                'message' => 'Document not found'
            ], 404);
        }

        // Get existing files
        $existingFiles = json_decode($document->file_path, true) ?: [];

        // Handle deleted files
        if ($request->has('deleted_files')) {
            $deletedFiles = json_decode($request->deleted_files, true);
            foreach ($deletedFiles as $file) {
                // Remove from storage
                Storage::delete('public/' . str_replace('storage/', '', $file));
                
                // Remove from existing files array
                $existingFiles = array_diff($existingFiles, [$file]);
            }
            // Reindex array
            $existingFiles = array_values($existingFiles);
        }

        // Handle new uploaded files
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                $fileName = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('document', $fileName, 'public');
                $existingFiles[] = 'storage/document/' . $fileName;
            }
        }

        if ($request->filled('file_name')) {
            $document->file_name = $request->file_name;
        }
        if ($request->filled('file_path')) {
            $document->file_name =json_encode($existingFiles);
        }
        if ($request->filled('description')) {
            $document->description = $request->description;
        }
        if ($request->filled('status')) {
            $document->status = $request->status;
        }
        if ($request->filled('valid_from')) {
            $document->valid_from = $request->valid_from;
        }
        if ($request->filled('valid_until')) {
            $document->valid_until = $request->valid_until;
        }
        if ($request->filled('category_id')) {
            $document->category_id = $request->category_id;
        }
        if ($request->filled('uploaded_by')) {
            $document->uploaded_by = $request->uploaded_by;
        }
        $document->save();

        return response()->json([
            'status' => true,
            'message' => 'Document updated successfully',
            'document_id' => $document->id
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error updating document: ' . $e->getMessage());
        
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while updating the document.'
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
