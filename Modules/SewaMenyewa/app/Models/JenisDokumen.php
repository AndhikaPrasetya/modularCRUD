<?php

namespace Modules\SewaMenyewa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SewaMenyewa\Database\Factories\JenisDokumenFactory;

class JenisDokumen extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'jenis_dokumen';
    protected $fillable = [
        'nama_jenis_dokumen'
    ];

    public function sewamenyewa(){
        return $this->hasMany(SewaMenyewa::class);
    }

    // protected static function newFactory(): JenisDokumenFactory
    // {
    //     // return JenisDokumenFactory::new();
    // }
}
