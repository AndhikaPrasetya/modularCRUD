<?php

namespace Modules\SewaMenyewa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Perusahaan\Models\profilePerusahaan;

// use Modules\SewaMenyewa\Database\Factories\LokasiFactory;

class Lokasi extends Model
{
    use HasFactory;

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

    // protected static function newFactory(): LokasiFactory
    // {
    //     // return LokasiFactory::new();
    // }
}
