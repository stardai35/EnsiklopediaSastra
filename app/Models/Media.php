<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(MediaType::class, 'type_id');
    }

    public function position()
    {
        return $this->belongsTo(MediaPosition::class, 'position_id');
    }
}
