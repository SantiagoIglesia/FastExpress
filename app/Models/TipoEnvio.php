<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoEnvio extends Model
{
    protected $fillable = [
        'nom_tipo_env', 'porc_recargo'
    ];

    protected $table = 'tipos_envio';

    protected $primaryKey = 'cod_tipo_env';

    protected $casts = ['porc_recargo' => 'decimal:2'];

    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'tipo_env_cod', 'cod_tipo_env');
    }
}
