<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Modules\SewaMenyewa\Models\Lokasi;
use Illuminate\Database\Eloquent\Model;
use Modules\Perusahaan\Models\AktaPerusahaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
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
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Roles');
    }
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

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }

    // protected static function newFactory(): ProfilePerusahaanFactory
    // {
    //     // return ProfilePerusahaanFactory::new();
    // }
}
