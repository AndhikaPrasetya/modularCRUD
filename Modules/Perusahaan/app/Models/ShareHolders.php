<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Perusahaan\Database\Factories\ShareHoldersFactory;

class ShareHolders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    //table
    protected $table = 'shareholders';
    protected $fillable = [
        'pemegang_saham',
        'jumlah_saham',
        'saham_persen'
    ];

    // protected static function newFactory(): ShareHoldersFactory
    // {
    //     // return ShareHoldersFactory::new();
    // }
}
