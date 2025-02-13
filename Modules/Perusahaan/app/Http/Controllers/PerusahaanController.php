<?php

namespace Modules\Perusahaan\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\Perusahaan\Models\profilePerusahaan;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Perusahaan";
        $breadcrumb = "Perusahaan";
        if ($request->ajax()) {
            $data = profilePerusahaan::query();
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('alamat', function ($data) {
                    return $data->alamat;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Gate::allows('update-profilePerusahaan')) {
                        $buttons .= '<a href="' . route('perusahaan.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Gate::allows('delete-profilePerusahaan')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="perusahaan">' .
                            ' Delete</button>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('perusahaan::ProfilePerusahaan.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Data Perusahaan";
        $breadcrumb = "Perusahaan";
        return view('perusahaan::ProfilePerusahaan.create', get_defined_vars());
    }

    public function getPerusahaanDomisili(Request $request)
    {
        $perusahaan = profilePerusahaan::find($request->id);
        if ($perusahaan) {
            return response()->json([
                'success' => true,
                'domisili' => $perusahaan->alamat_domisili,
            ]);
        }
        return response()->json(['success' => false], 404);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:profile_perusahaans,email',
            'kode_pos' => 'required',
            'no_domisili' => 'required',
            'nama_domisili' => 'required',
            'alamat_domisili' => 'required',
            'province_domisili' => 'required',
            'kota_domisili' => 'required',
            'no_npwp' => 'required',
            'nama_npwp' => 'required',
            'alamat_npwp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = new profilePerusahaan();
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->no_telp = $request->no_telp;
        $data->email = $request->email;
        $data->kode_pos = $request->kode_pos;
        $data->no_domisili = $request->no_domisili;
        $data->nama_domisili = $request->nama_domisili;
        $data->alamat_domisili = $request->alamat_domisili;
        $data->province_domisili = $request->province_domisili;
        $data->kota_domisili = $request->kota_domisili;
        $data->no_npwp = $request->no_npwp;
        $data->nama_npwp = $request->nama_npwp;
        $data->alamat_npwp = $request->alamat_npwp;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan',
        ], 200);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {

        return view('perusahaan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit Data Perusahaan";
        $breadcrumb = "Perusahaan";
        $data = profilePerusahaan::findOrFail($id);
        return view('perusahaan::ProfilePerusahaan.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:profile_perusahaans,email',
            'kode_pos' => 'required',
            'no_domisili' => 'required',
            'nama_domisili' => 'required',
            'alamat_domisili' => 'required',
            'province_domisili' => 'required',
            'kota_domisili' => 'required',
            'no_npwp' => 'required',
            'nama_npwp' => 'required',
            'alamat_npwp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = profilePerusahaan::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Perusahaan Berhasil Diupdate',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = profilePerusahaan::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Perusahaan Berhasil Dihapus',
        ], 200);
    }
}
