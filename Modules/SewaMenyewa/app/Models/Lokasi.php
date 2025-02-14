<?php

namespace Modules\SewaMenyewa\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Perusahaan\Models\profilePerusahaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\SewaMenyewa\Database\Factories\LokasiFactory;

class Lokasi extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'lokasi';
    protected $fillable = [
        'uid_profile_perusahaan',
        'nama',
        'alamat',
        'phone',
        'category',
        'type',
        'status',
        'luas',
        'harga',
        'pph',
        'ppn',
        'deposit',
        'pembayar_pbb',
        'no_pbb',
        'id_pln',
        'daya',
        'id_pdam',
        'denda_telat_bayar',
        'denda_pembatalan',
        'denda_pengosongan'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(profilePerusahaan::class, 'uid_profile_perusahaan');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nama',
                'alamat',
                'phone',
                'category',
                'type',
                'status',
                'luas',
                'harga',
                'pph',
                'ppn',
                'deposit',
                'pembayar_pbb',
                'no_pbb',
                'id_pln',
                'daya',
                'id_pdam',
                'denda_telat_bayar',
                'denda_pembatalan',
                'denda_pengosongan'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Lokasi');
    }
    // protected static function newFactory(): LokasiFactory
    // {
    //     // return LokasiFactory::new();
    // }
}
