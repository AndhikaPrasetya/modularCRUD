<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Perusahaan\Database\Factories\AktaPerusahaanFactory;

class AktaPerusahaan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uid_profile_perusahaan',
        'kode_akta',
        'nama_akta',
        'no_doc',
        'tgl_terbit',
        'nama_notaris',
        'domisili_perusahaan',
        'sk_kemenkum_ham',
        'status'
    ];

    public function Perusahaan()
    {
        return $this->belongsTo(profilePerusahaan::class, 'uid_profile_perusahaan');
    }




    // protected static function newFactory(): AktaPerusahaanFactory
    // {
    //     // return AktaPerusahaanFactory::new();
    // }
}
