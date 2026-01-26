<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;

    public function contents()
    {
        return $this->hasMany(Content::class, 'cat_id');
    }
}
