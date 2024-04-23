<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utiliti extends Model
{
    use HasFactory;
    public $table = 'tblutiliti';
    public $primaryKey = 'utiliti_id';
    public $timestamps = false;

    protected $fillable = ['uti_session', 'uti_fasiliti_id', 'uti_date', 'uti_tahun', 'uti_bulan', 'uti_type', 'uti_amaun'];
}
