<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['type_id', 'content_id', 'position_id', 'link', 'caption'];
    protected $table = 'media';

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * Get the full URL for the media link
     */
    public function getImageUrlAttribute()
    {
        if (!$this->link) {
            return null;
        }

        // If link is already a full URL, return as is
        if (filter_var($this->link, FILTER_VALIDATE_URL)) {
            return $this->link;
        }

        // If link starts with http:// or https://, return as is
        if (str_starts_with($this->link, 'http://') || str_starts_with($this->link, 'https://')) {
            return $this->link;
        }

        // Otherwise, prepend storage/ for Laravel storage paths
        return asset('storage/' . $this->link);
    }
}
