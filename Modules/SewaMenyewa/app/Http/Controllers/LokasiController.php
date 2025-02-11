<?php

namespace Modules\SewaMenyewa\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Perusahaan\Models\profilePerusahaan;
use Modules\SewaMenyewa\Models\internet;
use Modules\SewaMenyewa\Models\Lokasi;
use Modules\SewaMenyewa\Models\nopd;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Lokasi";
        $breadcrumb = "Lokasi";
        if ($request->ajax()) {
            $data = Lokasi::with('Perusahaan');
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('nama', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('uid_profile_perusahaan', function ($data) {
                    return $data->perusahaan ?  $data->perusahaan->nama : '';
                })
                ->addColumn('category', function ($data) {
                    return $data->category;
                })
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('status', function ($data) {
                    return '<span class="badge badge-primary">' . $data->status . '</span>';
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Auth::user()->can('update-lokasi')) {
                        $buttons .= '<a href="' . route('lokasi.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Auth::user()->can('delete-lokasi')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="lokasi">' .
                            ' Delete</button>';
                    }


                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('sewamenyewa::Lokasi.index', get_defined_vars());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Lokasi";
        $perusahaan = profilePerusahaan::all();
        return view('sewamenyewa::Lokasi.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid_profile_perusahaan' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'category' => 'required',
            'type' => 'required',
            'status' => 'required',
            'luas' => 'required',
            'harga' => 'required',
            'pph' => 'required',
            'ppn' => 'required',
            'deposit' => 'required',
            'pembayar_pbb' => 'required|string',
            'no_pbb' => 'required',
            'id_pln' => 'required',
            'daya' => 'required',
            'id_pdam' => 'required',
            'denda_telat_bayar' => 'required',
            'denda_pembatalan' => 'required',
            'denda_pengosongan' => 'required',
            'nopd.*' => 'required',
            'bentuk.*' => 'required',
            'ukuran.*' => 'required',
            'id_internet.*' => 'required',
            'speed_internet.*' => 'required',
            'harga_internet.*' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $lokasi = new Lokasi();
            $lokasi->uid_profile_perusahaan = $request->uid_profile_perusahaan;
            $lokasi->nama = $request->nama;
            $lokasi->alamat = $request->alamat;
            $lokasi->phone = $request->phone;
            $lokasi->category = $request->category;
            $lokasi->type = $request->type;
            $lokasi->status = $request->status;
            $lokasi->luas = $request->luas;
            $lokasi->harga = $request->harga;
            $lokasi->pph = $request->pph;
            $lokasi->ppn = $request->ppn;
            $lokasi->deposit = $request->deposit;
            $lokasi->pembayar_pbb = $request->pembayar_pbb;
            $lokasi->no_pbb = $request->no_pbb;
            $lokasi->id_pln = $request->id_pln;
            $lokasi->daya = $request->daya;
            $lokasi->id_pdam = $request->id_pdam;
            $lokasi->denda_telat_bayar = $request->denda_telat_bayar;
            $lokasi->denda_pembatalan = $request->denda_pembatalan;
            $lokasi->denda_pengosongan = $request->denda_pengosongan;
            $lokasi->save();

            $nopd = $request->nopd;
            $bentuk = $request->bentuk;
            $ukuran = $request->ukuran;

            foreach ($nopd as $key => $item) {
                $lokasi_nopd =new nopd();
                $lokasi_nopd->lokasi_id = $lokasi->id;
                $lokasi_nopd->nopd = $item;
                $lokasi_nopd->bentuk = $bentuk[$key];
                $lokasi_nopd->ukuran = $ukuran[$key];
                $lokasi_nopd->save();
            }

            $internetService = $request->id_internet;
            $speed_internet = $request->speed_internet;
            $harga_internet = $request->harga_internet;

            foreach ($internetService as $key => $internet) {
                $lokasi_internet = new internet();
                $lokasi_internet->lokasi_id = $lokasi->id;
                $lokasi_internet->id_internet = $internet;
                $lokasi_internet->speed_internet = $speed_internet[$key];
                $lokasi_internet->harga_internet = $harga_internet[$key];
                $lokasi_internet->save();
            }


            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditambahkan',
                'lokasiId' => $lokasi->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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
        $title = "Edit Lokasi";
        $breadcrumb = "Lokasi";
        $perusahaan = profilePerusahaan::all();

        $lokasi = Lokasi::findOrFail($id);
        $internetServices = internet::where('lokasi_id', $id)->get();
        $lokasiNopd = nopd::where('lokasi_id', $id)->get();
        return view('sewamenyewa::Lokasi.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'uid_profile_perusahaan' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'category' => 'required',
            'type' => 'required',
            'status' => 'required',
            'luas' => 'required',
            'harga' => 'required',
            'pph' => 'required',
            'ppn' => 'required',
            'deposit' => 'required',
            'pembayar_pbb' => 'required|string',
            'no_pbb' => 'required',
            'id_pln' => 'required',
            'daya' => 'required',
            'id_pdam' => 'required',
            'denda_telat_bayar' => 'required',
            'denda_pembatalan' => 'required',
            'denda_pengosongan' => 'required',
            'nopd.*' => 'required',
            'bentuk.*' => 'required',
            'ukuran.*' => 'required',
            'id_internet.*' => 'required',
            'speed_internet.*' => 'required',
            'harga_internet.*' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $lokasi = Lokasi::findOrFail($id);

            $lokasi->update([
                'uid_profile_perusahaan' => $request->uid_profile_perusahaan,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'phone' => $request->phone,
                'category' => $request->category,
                'type' => $request->type,
                'status' => $request->status,
                'luas' => $request->luas,
                'harga' => $request->harga,
                'pph' => $request->pph,
                'ppn' => $request->ppn,
                'deposit' => $request->deposit,
                'pembayar_pbb' => $request->pembayar_pbb,
                'no_pbb' => $request->no_pbb,
                'id_pln' => $request->id_pln,
                'daya' => $request->daya,
                'id_pdam' => $request->id_pdam,
                'denda_telat_bayar' => $request->denda_telat_bayar,
                'denda_pembatalan' => $request->denda_pembatalan,
                'denda_pengosongan' => $request->denda_pengosongan,
            ]);
            
            foreach($request->nopd as $key => $nopd){
                nopd::updateOrCreate(
                    [
                        'id' => $request->id_nopd[$key] ?? null,
                    ],
                    [
                        'lokasi_id' => $lokasi->id,
                        'nopd' => $nopd,
                        'bentuk' => $request->bentuk[$key] ?? null,
                        'ukuran' => $request->ukuran[$key] ?? null,
                    ]
                );
            }
            foreach($request->id_internet as $key => $internet){
                internet::updateOrCreate(
                    [
                        'id' => $request->internet_id[$key] ?? null,
                    ],
                    [
                        'lokasi_id' => $lokasi->id,
                        'id_internet' => $internet,
                        'speed_internet' => $request->speed_internet[$key] ?? null,
                        'harga_internet' => $request->harga_internet[$key] ?? null,
                    ]
                );
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Diupdate',
                'lokasi' => $lokasi
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Diupdate',
                'error' => $e->getMessage()
                ]);
                //log 
        Log::error(
            'Error update data lokasi',
            [
                'error' => $e->getMessage(),
            ]
            );
        }
    }

    public function deleteNopd($id)
    {
        $data = Nopd::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }
    public function deleteInternet($id)
    {
        $data = internet::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Lokasi::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }
}
