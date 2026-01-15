<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // Relasi ke Lemma (Judul)
    public function lemma()
    {
        return $this->belongsTo(Lemma::class, 'title_id');
    }

    // Relasi ke Media (Gambar/Video)
    public function media()
    {
        return $this->hasMany(Media::class, 'content_id');
    }

    // Relasi ke Referensi Link
    public function refLinks()
    {
        return $this->hasMany(RefLink::class, 'content_id');
    }
}
