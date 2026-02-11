<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];
    protected $table = 'category';

    public function contents()
    {
        return $this->hasMany(Content::class, 'cat_id');
    }
}
