<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $table = 'media_type';
    protected $fillable = ['type'];

    public function media()
    {
        return $this->hasMany(Media::class, 'type_id');
    }
}
