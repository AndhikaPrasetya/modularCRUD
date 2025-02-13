<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SewaMenyewaReminderMail;
use Yajra\DataTables\Facades\DataTables;
use Modules\SewaMenyewa\Models\SewaMenyewa;

class DashboardController extends Controller
{
    public function ReminderDokumen(){
        $today = Carbon::now()->format('Y-m-d');
        $tgl_expired = Carbon::now()->addDays(7)->format('Y-m-d');
    
        // Ambil semua sertifikat yang akan kedaluwarsa
        $listSertifikatSewa = SewaMenyewa::
            select('id', 'no_sertifikat','no_dokumen', 'tgl_akhir_sertifikat')
            ->whereBetween('tgl_akhir_sertifikat', [$today, $tgl_expired])
            ->get();
            return view('dashboard',get_defined_vars());
    }
    
}
