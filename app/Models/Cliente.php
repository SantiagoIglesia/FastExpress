<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $fillable = [
        'cod_cliente',
        'nom_cliente',
        'seg_nom_cliente',
        'ape_cliente',
        'seg_ape_cliente',
        'dir_cliente',
        'tel_cliente',
        'cant_env',
        'tipo_cli_cod'
    ];

    protected $table = 'clientes';

    protected $primaryKey = 'cod_cliente';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = ['cant_env' => 'integer'];

    public function tipoCliente(): BelongsTo
    {
        return $this->belongsTo(TipoCliente::class, 'tipo_cli_cod', 'cod_tipo_cli');
    }

    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'cliente_cod', 'cod_cliente');
    }
}
