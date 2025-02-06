<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
// use Modules\Perusahaan\Database\Factories\ProfilePerusahaanFactory;

class profilePerusahaan extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     */
    
     protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'email',
        'kode_pos',
        'no_domisili',
        'nama_domisili',
        'alamat_domisili',
        'province_domisili',
        'kota_domisili',
        'no_npwp',
        'nama_npwp',
        'alamat_npwp',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function aktaPerusahaan()
    {
        return $this->hasMany(AktaPerusahaan::class);
    }
    
    // protected static function newFactory(): ProfilePerusahaanFactory
    // {
    //     // return ProfilePerusahaanFactory::new();
    // }
}
