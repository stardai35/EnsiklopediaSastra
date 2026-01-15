<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPosition extends Model
{
    protected $table = 'media_position';
    protected $fillable = ['position'];

    public function media()
    {
        return $this->hasMany(Media::class, 'position_id');
    }
}
