<?php

namespace Modules\Perusahaan\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Perusahaan\Database\Factories\AktaPerusahaanFactory;

class AktaPerusahaan extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'kode_akta',
                'nama_akta',
                'no_doc',
                'tgl_terbit',
                'nama_notaris',
                'domisili_perusahaan',
                'sk_kemenkum_ham',
                'status'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Akta Perusahaan');
    }




    // protected static function newFactory(): AktaPerusahaanFactory
    // {
    //     // return AktaPerusahaanFactory::new();
    // }
}
