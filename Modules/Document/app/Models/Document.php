<?php

namespace Modules\Document\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'file_name',
        'status',
        'description',
        
    ];


    public function category()
    {
        return $this->belongsTo(DocumentCategories::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // protected static function newFactory(): DocumentFactory
    // {
    //     // return DocumentFactory::new();
    // }
}
