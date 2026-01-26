<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['content_id', 'path', 'alt_text'];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
