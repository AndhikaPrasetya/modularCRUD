<?php

namespace Modules\Perusahaan\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Perusahaan\Database\Factories\DirectorsFactory;

class Directors extends Model
{
    use HasFactory,LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'akta_perusahaan_id',
        'nama_direktur',
        'jabatan',
        'durasi_jabatan'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'akta_perusahaan_id',
                'nama_direktur',
                'jabatan',
                'durasi_jabatan'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Direktur');
    }

    // protected static function newFactory(): DirectorsFactory
    // {
    //     // return DirectorsFactory::new();
    // }
}
