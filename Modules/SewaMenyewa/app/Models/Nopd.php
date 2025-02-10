<?php

namespace Modules\SewaMenyewa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SewaMenyewa\Database\Factories\NopdFactory;

class nopd extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [
        'lokasi_id',
        'nopd',
        'bentuk',
        'ukuran'
    ];

    // protected static function newFactory(): NopdFactory
    // {
    //     // return NopdFactory::new();
    // }
}
