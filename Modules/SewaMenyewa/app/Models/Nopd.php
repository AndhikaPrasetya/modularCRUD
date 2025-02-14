<?php

namespace Modules\SewaMenyewa\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\SewaMenyewa\Database\Factories\NopdFactory;

class nopd extends Model
{
    use HasFactory,LogsActivity;

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'lokasi_id',
        'nopd',
        'bentuk',
        'ukuran'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'lokasi_id',
                'nopd',
                'bentuk',
                'ukuran'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Nopd');
    }

    // protected static function newFactory(): NopdFactory
    // {
    //     // return NopdFactory::new();
    // }
}
