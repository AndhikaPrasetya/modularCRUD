<?php

namespace Modules\Perusahaan\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Perusahaan\Database\Factories\ShareHoldersFactory;

class ShareHolders extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    //table
    protected $table = 'shareholders';
    protected $fillable = [
        'akta_perusahaan_id',
        'pemegang_saham',
        'jumlah_saham',
        'saham_persen'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'akta_perusahaan_id',
                'pemegang_saham',
                'jumlah_saham',
                'saham_persen'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('ShareHolders');
    }

    // protected static function newFactory(): ShareHoldersFactory
    // {
    //     // return ShareHoldersFactory::new();
    // }
}
