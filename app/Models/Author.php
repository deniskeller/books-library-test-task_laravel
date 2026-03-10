<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $table = 'authors';
    protected $primaryKey = 'id';
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'updated_date';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_authors');
    }
}
