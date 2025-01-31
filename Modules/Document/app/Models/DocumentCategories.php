<?php

namespace Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Document\Database\Factories\DocumentCategoriesFactory;

class DocumentCategories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
    ];

    public function documents(){
        return $this->hasMany(Document::class);
    }

    // protected static function newFactory(): DocumentCategoriesFactory
    // {
    //     // return DocumentCategoriesFactory::new();
    // }
}
