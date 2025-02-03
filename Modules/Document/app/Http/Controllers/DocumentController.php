<?php

namespace Modules\Document\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Document\Models\Document;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\Document\Models\AttachmentDocument;
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
                    return $data->status;
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
        $documentStatus = ['active', 'expired'];
        return view('document::DocumentView.create', compact('category', 'title', 'documentStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
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
            DB::beginTransaction();

            $document = new Document();
            $document->file_name = $request->file_name;
            $document->description = $request->description;
            $document->status = $request->status;
            $document->valid_from = $request->valid_from;
            $document->valid_until = $request->valid_until;
            $document->category_id = $request->category_id;
            $document->uploaded_by = Auth::id();
            $document->save();


            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('document', $fileName, 'public');
                    $fileData = 'storage/document/' . $fileName;

                    $attachment = new AttachmentDocument();
                    $attachment->document_id = $document->id;
                    $attachment->file_path = $fileData;
                    $attachment->save();
                }
            }

            DB::commit();

            // Log::debug('Document created: ', [
            //     'document_id' => $document->id,
            //     'status' => $document->status,
            //     'attachments' => $fileData
            // ]);

            return response()->json([
                'status' => true,
                'message' => 'Document Created Successfully',
                'document_id' => $document->id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah terupload jika terjadi error
            if (!empty($fileData)) {
                foreach ($fileData as $file) {
                    if (Storage::exists('public/document/' . basename($file))) {
                        Storage::delete('public/document/' . basename($file));
                    }
                }
            }

            // Log::error('Error creating document: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'error' => 'An error occurred while creating the document.'
            ], 500);
        }
    }



    public function edit($id)
    {
        $title = "Create Category";
        $breadcrumb = "Create";
        $document = Document::find($id);
        $category = DocumentCategories::all();
        $existingAttachment = AttachmentDocument::where('document_id', $id)->get();
        return view('document::DocumentView.edit', compact('title', 'breadcrumb', 'document', 'category', 'existingAttachment'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'nullable',
            'file_path.*' => 'mimes:pdf,xlsx,csv|max:2048',
            'description' => 'nullable',
            'status' => 'nullable',
            'valid_from' => 'nullable',
            'valid_until' => 'nullable',
            'category_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $document = Document::find($id);
            if (!$document) {
                return response()->json(['status' => false, 'message' => 'Document not found'], 404);
            }
  
            $updateData = [];

            if ($request->filled('file_name')) {
                $updateData['file_name'] = $request->file_name;
            }
            if ($request->filled('status')) {
                $updateData['status'] = $request->status;
            }
            if ($request->filled('valid_from')) {
                $updateData['valid_from'] = $request->valid_from;
            }
            if ($request->filled('valid_until')) {
                $updateData['valid_until'] = $request->valid_until;
            }
            if ($request->filled('category_id')) {
                $updateData['category_id'] = $request->category_id;
            }
            if ($request->filled('description')) {
                $updateData['description'] = $request->description;
            }

            $document->uploaded_by = Auth::id();

            $document->update($updateData);


            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('document', $fileName, 'public');
                    $fileData = 'storage/document/' . $fileName;
            
                    // Check if this exact file already exists for this document
                    $existingAttachment = AttachmentDocument::where('document_id', $document->id)
                        ->where('file_path', $fileData)
                        ->first();
            
                    if (!$existingAttachment) {
                        $attachment = new AttachmentDocument();
                        $attachment->document_id = $document->id;
                        $attachment->file_path = $fileData;
                        $attachment->save();
                    }
                }
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Document updated successfully',
                'document' => $document
            ], 200);
        } catch (\Exception $e) {
            // \Log::error('Error updating document: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the document.'
            ], 500);
        }
    }

    public function deleteFile($id)
{
    try {
    
        $file = AttachmentDocument::findOrFail($id);
        
        
        if (Storage::exists('public/'.basename($file->file_path))) {
            Storage::delete('public/'.basename($file->file_path));
        }

        // Hapus dari database
        $file->delete();

        return response()->json(['message' => 'File berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Gagal menghapus file'], 500);
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
