<?php

namespace Modules\SewaMenyewa\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\SewaMenyewa\Database\Factories\InternteFactory;

class internet extends Model
{
    use HasFactory,LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'internet';
    protected $fillable = [
        'lokasi_id',
        'id_internet',
        'speed_internet',
        'harga_internet'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'lokasi_id',
                'id_internet',
                'speed_internet',
                'harga_internet'
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Internet');
    }

    // protected static function newFactory(): InternteFactory
    // {
    //     // return InternteFactory::new();
    // }
}
