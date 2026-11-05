<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $fillable = [
        'nom_param', 'valor'
    ];

    protected $table = 'parametros';

    protected $primaryKey = 'cod_param';

    protected $casts = ['valor' => 'decimal:2'];
}
