<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SewaMenyewaReminderMail;
use Modules\SewaMenyewa\Models\SewaMenyewa;

class DashboardController extends Controller
{
    public function cekSertifikatSewaMenyewa()
    {
        $today = Carbon::now()->format('Y-m-d');
        $tgl_expired = Carbon::now()->addDays(7)->format('Y-m-d');
        $user = Auth::user();
    
        $listSertifikat = SewaMenyewa::select('id', 'no_sertifikat', 'tgl_akhir_sertifikat')
            ->whereBetween('tgl_akhir_sertifikat', [$today,$tgl_expired])
            ->get();
    
        if ($listSertifikat->isNotEmpty()) {
            Mail::to($user->email)->send(new SewaMenyewaReminderMail($listSertifikat, $user));
        }
    
        return response()->json(['message' => 'Notifikasi sertifikat telah dikirim.']);
    }
    
}
