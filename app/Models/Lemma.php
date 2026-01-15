<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lemma extends Model
{
    protected $table = 'lemma'; 
    protected $primaryKey = 'id';
     protected $fillable = ['name', 'slug'];
    public $timestamps = false; 
}
