<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasiliti extends Model
{
    use HasFactory;
    public $table = 'tblfasiliti';
    public $primaryKey = 'fasiliti_id';
    public $timestamps = false;

    public function negeri(){
        return $this->belongsTo(\App\Models\Negeri::class, 'fas_negeri_id', 'neg_kod_negeri');
    }
    public function kategori(){
        return $this->belongsTo(\App\Models\Kategori::class, 'fas_kat_kod', 'faskat_kod');
    }
}
