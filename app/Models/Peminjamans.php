<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjamans extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nis',
        'nama',
        'rombel',
        'rayon',

    ];
}
