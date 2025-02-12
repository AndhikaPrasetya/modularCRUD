<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SewaMenyewaReminderMail;
use Modules\SewaMenyewa\Models\SewaMenyewa;

class CekDokumen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cek-dokumen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $today = Carbon::now()->format('Y-m-d');
        $tgl_expired = Carbon::now()->addDays(7)->format('Y-m-d');

        $listSertifikat = SewaMenyewa::select('id', 'no_sertifikat', 'tgl_akhir_sertifikat')
            ->whereBetween('tgl_akhir_sertifikat', [$today, $tgl_expired])
            ->get();

        if ($listSertifikat->isNotEmpty()) {
            foreach ($listSertifikat as $sertifikat) {
                if (!empty($sertifikat->tgl_akhir_sertifikat)) {
                    Mail::to('andhika@example.com')->send(new SewaMenyewaReminderMail($sertifikat));
                }
            }
            $this->info("Notifikasi sertifikat telah dikirim.");
        } else {
            $this->info("Tidak ada sertifikat yang kedaluwarsa dalam 7 hari.");
        }
    }
}
