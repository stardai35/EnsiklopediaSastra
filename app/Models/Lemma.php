<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lemma extends Model
{
    protected $fillable = ['name'];
    protected $table = 'lemma';

    public function contents()
    {
        return $this->hasMany(Content::class, 'title_id');
    }

    /**
     * Get formatted name with encoding fixes
     */
    public function getFormattedNameAttribute()
    {
        if (!$this->name) {
            return null;
        }

        $name = $this->name;
        
        // Fix common UTF-8 encoding issues in names
        $name = str_replace('â€™', "—", $name); // Right single quotation mark (apostrophe)
        $name = str_replace('â€TM', "—", $name); // Another apostrophe encoding
        $name = str_replace('â€"', '–', $name); // En dash
        $name = str_replace('â€"', '—', $name); // Em dash
        $name = str_replace('â€œ', '—', $name); // Left double quotation mark
        $name = str_replace('â€', '—', $name); // Right double quotation mark
        $name = str_replace('â€¦', '—', $name); // Ellipsis
        
        // Clean up any remaining encoding artifacts
        $name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
        
        // Trim whitespace
        $name = trim($name);
        
        return $name ?: $this->name;
    }
}
