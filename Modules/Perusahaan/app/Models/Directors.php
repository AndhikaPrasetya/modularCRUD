<?php

namespace Modules\Perusahaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Perusahaan\Database\Factories\DirectorsFactory;

class Directors extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): DirectorsFactory
    // {
    //     // return DirectorsFactory::new();
    // }
}
