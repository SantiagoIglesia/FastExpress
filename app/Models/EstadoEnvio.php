<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoEnvio extends Model
{
    protected $fillable = [
        'nom_estado'
    ];

    protected $table = 'estados_envio';

    protected $primaryKey = 'cod_estado';

    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'estado_cod', 'cod_estado');
    }
}
