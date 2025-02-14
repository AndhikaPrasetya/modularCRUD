<?php

namespace Modules\Perusahaan\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Perusahaan\Database\Factories\AttachmentAktaPerusahaanFactory;

class AttachmentAktaPerusahaan extends Model
{
    use HasFactory,SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'akta_perusahaan_id',
        'file_path',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'akta_perusahaan_id',
                'file_path',
            ])
            ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name . " has been {$eventName}")
            ->useLogName('Attachment Akta Perusahaan');
    }

    // protected static function newFactory(): AttachmentAktaPerusahaanFactory
    // {
    //     // return AttachmentAktaPerusahaanFactory::new();
    // }
}
