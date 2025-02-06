<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Perusahaan\Database\Factories\AttachmentAktaPerusahaanFactory;

class AttachmentAktaPerusahaan extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): AttachmentAktaPerusahaanFactory
    // {
    //     // return AttachmentAktaPerusahaanFactory::new();
    // }
}
