<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Document\Database\Factories\AttachmentDocumentFactory;

class AttachmentDocument extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'document_id',
        'file_path',
    ];

    // protected static function newFactory(): AttachmentDocumentFactory
    // {
    //     // return AttachmentDocumentFactory::new();
    // }
}
