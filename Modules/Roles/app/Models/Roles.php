<?php

namespace Modules\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

// use Modules\Roles\Database\Factories\RolesFactory;

class Roles extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'permission'
        
    ];

    // protected static function newFactory(): RolesFactory
    // {
    //     // return RolesFactory::new();
    // }
}
