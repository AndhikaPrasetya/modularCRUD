<?php

namespace Modules\Roles\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Roles\Database\Factories\RolesFactory;

class Roles extends Model
{
    use HasFactory, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'permission'
        
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['name', 'permission'])
                ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name. " has been {$eventName}")
                ->useLogName('Roles');
    }
    // protected static function newFactory(): RolesFactory
    // {
    //     // return RolesFactory::new();
    // }
}
