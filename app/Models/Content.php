<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['cat_id', 'title', 'year', 'text', 'slug'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'content_id');
    }
}