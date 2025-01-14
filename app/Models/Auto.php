<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo',
        'color',
        'precio',
        'transmision',
        'submarca',
        'marca_id',
        'imagen'
    ];
}
