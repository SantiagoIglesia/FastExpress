<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $fillable = [
        'cod_param', 'nom_param', 'valor'
    ];
}
