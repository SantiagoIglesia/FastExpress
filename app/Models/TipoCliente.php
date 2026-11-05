<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoCliente extends Model
{
    protected $fillable = [
        'nom_tipo_cli', 'porc_descuento'
    ];

    protected $table = 'tipos_cliente';

    protected $primaryKey = 'cod_tipo_cli';

    protected $casts = ['porc_descuento' => 'decimal:2'];

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'tipo_cli_cod', 'cod_tipo_cli');
    }
}
