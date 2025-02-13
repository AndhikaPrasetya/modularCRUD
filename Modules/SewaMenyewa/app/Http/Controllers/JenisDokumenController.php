<?php

namespace Modules\SewaMenyewa\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Modules\SewaMenyewa\Models\JenisDokumen;

class JenisDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Jenis Dokumen";
        $breadcrumb = "Jenis Dokumen";
        if ($request->ajax()) {
            $data = JenisDokumen::query();
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('nama_jenis_dokumen', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('nama_jenis_dokumen', function ($data) {
                    return $data->nama_jenis_dokumen;
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Gate::allows('update-jenisDokumen')) {
                        $buttons .= '<a href="' . route('jenisDokumen.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Gate::allows('delete-jenisDokumen')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="jenisDokumen">' .
                            ' Delete</button>';
                    }


                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sewamenyewa::JenisDokumen.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Jenis Dokumen";
        $breadcrumb = "Jenis Dokumen";
        return view('sewamenyewa::JenisDokumen.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_dokumen' => 'required|string',
            ]);
        $jenisDokumen = new JenisDokumen();
        $jenisDokumen->nama_jenis_dokumen = $request->nama_jenis_dokumen;
        $jenisDokumen->save();
        return response()->json([
            'status' => true,
            'message' => 'Jenis Dokumen created successfully',
            'jenisDokumen' => $jenisDokumen,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('sewamenyewa::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit Jenis Dokumen";
        $breadcrumb = "Jenis Dokumen";
        $jenisDokumen = JenisDokumen::find($id);
        return view('sewamenyewa::JenisDokumen.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis_dokumen' => 'required|string',
            ]);
            $jenisDokumen = JenisDokumen::find($id);
            $jenisDokumen->update([
                'nama_jenis_dokumen' => $request->nama_jenis_dokumen,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Jenis Dokumen updated successfully',
                'jenisDokumen' => $jenisDokumen,
                ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = JenisDokumen::findOrFail($id);
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 500);
        }
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            ]);
    
    }
}
