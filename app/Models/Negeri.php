<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negeri extends Model
{
    use HasFactory;
    public $table = 'ddsa_kod_negeri';
    public $primaryKey = 'neg_negeri_id';
    public $timestamps = false;
}
