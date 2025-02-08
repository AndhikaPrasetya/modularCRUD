<?php

namespace Modules\Perusahaan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\Perusahaan\Models\AktaPerusahaan;
use Modules\Perusahaan\Models\profilePerusahaan;
use Modules\Perusahaan\Models\AttachmentAktaPerusahaan;
use Modules\Perusahaan\Models\Directors;
use Modules\Perusahaan\Models\ShareHolders;

class AktaPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Akta Perusahaan";
        $breadcrumb = "Akta Perusahaan";
        if ($request->ajax()) {
            $data = AktaPerusahaan::with('Perusahaan');
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('nama_akta', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('nama_akta', function ($data) {
                    return $data->nama_akta;
                })
                ->addColumn('uid_profile_perusahaan', function ($data) {
                    return $data->perusahaan ?  $data->perusahaan->nama : '';
                })
                ->addColumn('kode_akta', function ($data) {
                    return $data->kode_akta;
                })
                ->addColumn('tgl_terbit', function ($data) {
                    return $data->tgl_terbit;
                })
                ->addColumn('status', function ($data) {
                    return $data->status === 'active' ? '<span class="badge badge-primary">' . $data->status . '</span>' : '<span class="badge badge-danger">' . $data->status . '</span>';
                })
                ->addColumn('action', function ($data) {
                    $buttons = '<div class="text-center">';
                    //Check permission 
                    if (Auth::user()->can('update-category')) {
                        $buttons .= '<a href="' . route('aktaPerusahaan.edit', $data->id) . '" class="btn btn-outline-info btn-sm mr-1"><span>Edit</span></a>';
                    }
                    if (Auth::user()->can('delete-category')) {
                        $buttons .= '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="aktaPerusahaan">' .
                            ' Delete</button>';
                    }


                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('perusahaan::AktaPerusahaan.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = "Create Akta Perusahaan";
        $breadcrumb = "Akta Perusahaan";
        $perusahaan = profilePerusahaan::all();
        $selectedPerusahaan = null;

        if ($request->has('uid_profile_perusahaan')) {
            $selectedPerusahaan = profilePerusahaan::find($request->input('uid_profile_perusahaan'));
        }

        return view('perusahaan::AktaPerusahaan.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid_profile_perusahaan' => 'required',
            'file_path.*' => 'mimes:pdf,xlx,csv|max:2048',
            'nama_direktur.*' => 'required',
            'jabatan.*' => 'required',
            'durasi_jabatan.*' => 'required',
            'pemegang_saham.*' => 'required',
            'nominal_saham.*' => 'required',
            'saham_persen.*' => 'required',
            'nama_akta' => 'required',
            'kode_akta' => 'required',
            'no_doc' => 'required',
            'tgl_terbit' => 'required',
            'nama_notaris' => 'required',
            'keterangan' => 'nullable',
            'sk_kemenkum_ham' => 'required',
            'status' => 'required',
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
            $akta = new AktaPerusahaan();
            $akta->uid_profile_perusahaan = $request->uid_profile_perusahaan;
            $akta->nama_akta = $request->nama_akta;
            $akta->kode_akta = $request->kode_akta;
            $akta->no_doc = $request->no_doc;
            $akta->tgl_terbit = $request->tgl_terbit;
            $akta->nama_notaris = $request->nama_notaris;
            $akta->keterangan = $request->keterangan;
            $akta->sk_kemenkum_ham = $request->sk_kemenkum_ham;
            $akta->status = $request->status;
            $akta->save();

            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('aktaPerusahaan', $fileName, 'public');
                    $fileData = 'storage/aktaPerusahaan/' . $fileName;

                    $attachment = new AttachmentAktaPerusahaan();
                    $attachment->akta_perusahaan_id = $akta->id;
                    $attachment->file_path = $fileData;
                    $attachment->save();
                }
            }

            //input direktur
            $nama_direktur = $request->nama_direktur;
            $jabatan = $request->jabatan;
            $durasi_jabatan = $request->durasi_jabatan;

            foreach ($nama_direktur as $key => $nama) {
                $direktur = new Directors();
                $direktur->akta_perusahaan_id = $akta->id;
                $direktur->nama_direktur = $nama;
                $direktur->jabatan = $jabatan[$key];
                $direktur->durasi_jabatan = $durasi_jabatan[$key];
                $direktur->save();
            }

            //input saham 
            $nama_pemegang_saham = $request->pemegang_saham;
            $jumlah_saham = $request->jumlah_saham;
            $saham_persen = $request->saham_persen;

            foreach ($nama_pemegang_saham as $key => $nama) {
                $saham = new ShareHolders();
                $saham->akta_perusahaan_id = $akta->id;
                $saham->pemegang_saham = $nama;
                $saham->jumlah_saham = $jumlah_saham[$key];
                $saham->saham_persen = $saham_persen[$key];
                $saham->save();
            }


            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditambahkan',
                'perusahaanId' => $akta->id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Failed to save data',
                'errors' => $e->getMessage()
            ], 500);
        }
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
        $title = "Edit Akta Perusahaan";
        $breadcrumb = "Akta Perusahaan";

        $akta = AktaPerusahaan::with('perusahaan')->findOrFail($id);
        $perusahaan = ProfilePerusahaan::all();
        //mengambil domisili sesuai dengan perusahaan
        $domisili = $akta && $akta->perusahaan ? $akta->perusahaan->alamat : null;
        $existingAttachment = AttachmentAktaPerusahaan::where('akta_perusahaan_id', $id)->get();
        //get data direktur
        $direkturs = Directors::where('akta_perusahaan_id', $id)->get();
        $shareholders = ShareHolders::where('akta_perusahaan_id', $id)->get();



        return view('perusahaan::AktaPerusahaan.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'uid_profile_perusahaan' => 'required',
            'file_path.*' => 'mimes:pdf,xlx,csv|max:2048',
            'nama_direktur.*' => 'required',
            'jabatan.*' => 'required',
            'durasi_jabatan.*' => 'required',
            'pemegang_saham.*' => 'required',
            'nominal_saham.*' => 'required',
            'saham_persen.*' => 'required',
            'nama_akta' => 'required',
            'kode_akta' => 'required',
            'no_doc' => 'required',
            'tgl_terbit' => 'required',
            'nama_notaris' => 'required',
            'keterangan' => 'nullable',
            'sk_kemenkum_ham' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ]);
        }

        try {
            DB::beginTransaction();
            $akta = AktaPerusahaan::findOrFail($id);
            
            $akta->update([
            'uid_profile_perusahaan'  =>$request->uid_profile_perusahaan,
            'nama_akta' => $request->nama_akta,
            'kode_akta' => $request->kode_akta,
            'no_doc' => $request->no_doc,
            'tgl_terbit' => $request->tgl_terbit,
            'nama_notaris' => $request->nama_notaris,
            'keterangan' => $request->keterangan,
            'sk_kemenkum_ham' => $request->sk_kemenkum_ham,
            'status' => $request->status,
            ]);

            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('aktaPerusahaan', $fileName, 'public');
                    $fileData = 'storage/aktaPerusahaan/' . $fileName;

                     // Check if this exact file already exists for this document
                     $existingAttachment = AttachmentAktaPerusahaan::where('akta_perusahaan_id', $akta->id)
                     ->where('file_path', $fileData)
                     ->first();
         
                 if (!$existingAttachment) {
                    $attachment = new AttachmentAktaPerusahaan();
                    $attachment->akta_perusahaan_id = $akta->id;
                    $attachment->file_path = $fileData;
                    $attachment->save();
                 }
                   
                }
            }

         
            foreach ($request->nama_direktur as $key => $nama) {
                Directors::updateOrCreate(
                    [
                        'id' => $request->id_direktur[$key] ?? null, // Jika ID ada, update, jika null maka insert
                    ],
                    [
                        'akta_perusahaan_id' => $akta->id,
                        'nama_direktur' => $nama,
                        'jabatan' => $request->jabatan[$key] ?? null,
                        'durasi_jabatan' => $request->durasi_jabatan[$key] ?? null,
                    ]
                );
            }
            
            foreach ($request->pemegang_saham as $key => $nama) {
                ShareHolders::updateOrCreate(
                    [
                        'id' => $request->id_saham[$key] ?? null, // Jika ID ada, update, jika null maka insert
                    ],
                    [
                        'akta_perusahaan_id' => $akta->id,
                        'pemegang_saham' => $nama,
                        'jumlah_saham' => $request->jumlah_saham[$key] ?? null,
                        'saham_persen' => $request->saham_persen[$key] ?? null,
                    ]
                );
            }


            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditambahkan',
                'perusahaanId' => $akta->id
            ]);
        } catch (\Exception $e) {
             \Log::error('Error : ' . $e->getMessage());
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Failed to save data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteDirektur($id)
    {
        $data = Directors::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }
    public function deleteSaham($id)
    {
        $data = ShareHolders::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }

    public function deleteFile($id)
    {
        try {

            $file = AttachmentAktaPerusahaan::findOrFail($id);

            if (Storage::exists('public/' . basename($file->file_path))) {
                Storage::delete('public/' . basename($file->file_path));
            }

            $file->delete();

            return response()->json(['message' => 'File berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus file'], 500);
        }
    }

    public function destroy($id)
    {
        //
    }
}
