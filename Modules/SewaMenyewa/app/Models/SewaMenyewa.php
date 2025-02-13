<?php

namespace Modules\SewaMenyewa\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SewaMenyewa\Database\Factories\SewaMenyewaFactory;

class SewaMenyewa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sewa_menyewa';
    protected $fillable = [
        'lokasi_id',
        'user_id',
        'jenis_dokumen_id',
        'tentang',
        'no_dokumen',
        'nama_notaris',
        'tanggal_dokumen',
        'sign_by',
        'nama_pemilik_awal',
        'sewa_awal',
        'sewa_akhir',
        'sewa_grace_period',
        'sewa_handover',
        'no_sertifikat',
        'jenis_sertifikat',
        'tgl_sertifikat',
        'tgl_akhir_sertifikat'
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // protected static function newFactory(): SewaMenyewaFactory
    // {
    //     // return SewaMenyewaFactory::new();
    // }
}
