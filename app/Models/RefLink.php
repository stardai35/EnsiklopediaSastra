<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefLink extends Model
{
    protected $table = 'ref_link';
    protected $fillable = ['content_id', 'name', 'link'];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
