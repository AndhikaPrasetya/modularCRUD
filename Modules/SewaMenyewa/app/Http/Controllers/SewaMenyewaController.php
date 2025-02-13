<?php

namespace Modules\SewaMenyewa\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SewaMenyewaReminderMail;
use Illuminate\Support\Facades\Gate;
use Modules\SewaMenyewa\Models\Lokasi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\SewaMenyewa\Models\SewaMenyewa;
use Modules\SewaMenyewa\Models\JenisDokumen;

class SewaMenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Sewa Menyewa";
        $breadcrumb = "Sewa Menyewa";
        // (new SewaMenyewaController)->cekSertifikatSewa();
        if ($request->ajax()) {
            $data = SewaMenyewa::with(['lokasi','jenisDokumen']);
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('lokasi_id', 'like', "%{$search}%")
                    ->orWhere('no_dokumen', 'like', "%{$search}%")
                    ->orWhere('jenis_dokumen_id', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('no_dokumen', function ($data) {
                    return $data->no_dokumen;
                })
                ->addColumn('lokasi_id', function ($data) {
                    return $data->lokasi ?  $data->lokasi->nama : '';
                })
                ->addColumn('jenis_dokumen_id', function ($data) {
                    return $data->jenisDokumen ?  $data->jenisDokumen->nama_jenis_dokumen : '';
                })
                ->addColumn('tanggal_dokumen', function ($data) {
                    return \Carbon\Carbon::parse($data->tanggal_dokumen)->format('Y-m-d');
                })
                ->addColumn('sign_by', function ($data) {
                    return $data->sign_by;
                })
               
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Gate::allows('update-sewaMenyewa')) {
                        $buttons .= '<a href="' . route('sewaMenyewa.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Gate::allows('delete-sewaMenyewa')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="sewaMenyewa">' .
                            ' Delete</button>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sewamenyewa::SewaMenyewa.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Sewa Menyewa";
        $breadcrumb = "Sewa Menyewa";
        $jenisDokumen = JenisDokumen::all();
        $lokasi = Lokasi::all();
        return view('sewamenyewa::SewaMenyewa.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lokasi_id' => 'required|exists:lokasi,id',
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'tentang' => 'nullable|string',
            'no_dokumen' => 'required|string',
            'nama_notaris' => 'required|string',
            'tanggal_dokumen' => 'required|date',
            'sign_by' => 'required|string',
            'nama_pemilik_awal' => 'required|string',
            'sewa_awal' => 'required|date',
            'sewa_akhir' => 'required|date',
            'sewa_grace_period' => 'nullable|string',
            'sewa_handover' => 'required|date',
            'no_sertifikat' => 'required|string',
            'jenis_sertifikat' => 'required|in:HGB,SHM',
            'tgl_sertifikat' => 'required|date',
            'tgl_akhir_sertifikat' => 'required|date'
        ]);
        
        // Tambahkan pengecekan validasi
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            DB::beginTransaction();

            $data = new SewaMenyewa();
            $data->lokasi_id = $request->lokasi_id;
            $data->user_id = Auth::id();
            $data->jenis_dokumen_id = $request->jenis_dokumen_id;
            $data->tentang = $request->tentang;
            $data->no_dokumen = $request->no_dokumen;
            $data->nama_notaris = $request->nama_notaris;
            $data->tanggal_dokumen = $request->tanggal_dokumen;
            $data->sign_by = $request->sign_by;
            $data->nama_pemilik_awal = $request->nama_pemilik_awal;
            $data->sewa_awal = $request->sewa_awal;
            $data->sewa_akhir = $request->sewa_akhir;
            $data->sewa_grace_period = $request->sewa_grace_period;
            $data->sewa_handover = $request->sewa_handover;
            $data->no_sertifikat = $request->no_sertifikat;
            $data->jenis_sertifikat = $request->jenis_sertifikat;
            $data->tgl_sertifikat = $request->tgl_sertifikat;
            $data->tgl_akhir_sertifikat = $request->tgl_akhir_sertifikat;
            $data->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'sewaId' => $data->id
                ], 200);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data',
                'errors' => $e->getMessage()
                ], 500);
        }
    }

    public function show($id)
    {
        return view('sewamenyewa::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $title = "Edit Sewa Menyewa";
        $breadcrumb = "Sewa Menyewa";
        $jenisDokumen = JenisDokumen::all();
        $lokasi = Lokasi::all();
        $data = SewaMenyewa::find($id);
        return view('sewamenyewa::SewaMenyewa.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lokasi_id' => 'required|exists:lokasi,id',
           
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'tentang' => 'nullable|string',
            'no_dokumen' => 'required|string',
            'nama_notaris' => 'required|string',
            'tanggal_dokumen' => 'required|date',
            'sign_by' => 'required|string',
            'nama_pemilik_awal' => 'required|string',
            'sewa_awal' => 'required|date',
            'sewa_akhir' => 'required|date',
            'sewa_grace_period' => 'nullable|string',
            'sewa_handover' => 'required|date',
            'no_sertifikat' => 'required|string',
            'jenis_sertifikat' => 'required|in:HGB,SHM',
            'tgl_sertifikat' => 'required|date',
            'tgl_akhir_sertifikat' => 'required|date'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
 
        $tglAkhirSertifikat = $request->tgl_akhir_sertifikat;
    
        // Proses grace period sebelum update
        if ($request->filled('sewa_grace_period')) {
            // Ekstrak nilai grace period
            preg_match('/(\d+)\s*(bulan|hari)/i', $request->sewa_grace_period, $matches);
    
            if (!empty($matches)) {
                $nilaiGracePeriod = intval($matches[1]); // Pastikan integer
                $satuanWaktu = strtolower($matches[2]);
    
                // Konversi ke Carbon
                $carbonTglAkhir = \Carbon\Carbon::parse($tglAkhirSertifikat);
    
                // Tambahkan sesuai satuan waktu
                if ($satuanWaktu == 'bulan') {
                    $tglAkhirSertifikat = $carbonTglAkhir->addMonths($nilaiGracePeriod)->format('Y-m-d');
                } elseif ($satuanWaktu == 'hari') {
                    $tglAkhirSertifikat = $carbonTglAkhir->addDays($nilaiGracePeriod)->format('Y-m-d');
                }
            }
        }
    
        $data = SewaMenyewa::findOrFail($id);
        $data->update([
            'lokasi_id' => $request->lokasi_id,
            'user_id' => Auth::id(),
            'jenis_dokumen_id' => $request->jenis_dokumen_id,
            'tentang' => $request->tentang,
            'no_dokumen' => $request->no_dokumen,
            'nama_notaris' => $request->nama_notaris,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'sign_by' => $request->sign_by,
            'nama_pemilik_awal' => $request->nama_pemilik_awal,
            'sewa_awal' => $request->sewa_awal,
            'sewa_akhir' => $request->sewa_akhir,
            'sewa_grace_period' => $request->sewa_grace_period,
            'sewa_handover' => $request->sewa_handover,
            'no_sertifikat' => $request->no_sertifikat,
            'jenis_sertifikat' => $request->jenis_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'tgl_akhir_sertifikat' => $tglAkhirSertifikat
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SewaMenyewa::findOrFail($id);
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
