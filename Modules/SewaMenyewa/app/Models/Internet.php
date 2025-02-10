<?php

namespace Modules\SewaMenyewa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SewaMenyewa\Database\Factories\InternteFactory;

class internet extends Model
{
    use HasFactory;

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

    // protected static function newFactory(): InternteFactory
    // {
    //     // return InternteFactory::new();
    // }
}
