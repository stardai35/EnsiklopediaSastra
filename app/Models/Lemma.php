<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lemma extends Model
{
    // Sesuaikan dengan nama tabel di database Anda
    protected $table = 'lemma';
    
    // Matikan timestamps jika tabelnya tidak punya kolom created_at/updated_at
    public $timestamps = false;
}