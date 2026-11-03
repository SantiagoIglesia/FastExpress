<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Envio extends Model
{
    protected $fillable = [
        'fecha_envio',
        'peso_envio',
        'tarifa_base_envio',
        'costo_peso_envio',
        'subtotal_envio',
        'porc_desc_envio',
        'valor_desc_envio',
        'porc_rec_envio',
        'valor_rec_envio',
        'total_envio',
        'cliente_cod',
        'estado_cod',
        'tipo_env_cod',
        'rango_cod'
    ];

    protected $table = 'envios';

    protected $primaryKey = 'cod_envio';

    protected $casts = [
        'fecha_envio'       => 'datetime',
        'peso_envio'        => 'decimal:2',
        'tarifa_base_envio' => 'decimal:2',
        'costo_peso_envio'  => 'decimal:2',
        'subtotal_envio'    => 'decimal:2',
        'porc_des_envio'    => 'decimal:2',
        'valor_desc_envio'  => 'decimal:2',
        'porc_rec_envio'    => 'decimal:2',
        'valor_rec_envio'   => 'decimal:2',
        'total_envio'       => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_cod', 'cod_cliente');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoEnvio::class, 'estado_cod', 'cod_estado');
    }

    public function tipoEnvio(): BelongsTo
    {
        return $this->belongsTo(TipoEnvio::class, 'tipo_env_cod', 'cod_tipo_env');
    }

    public function rangoPeso(): BelongsTo
    {
        return $this->belongsTo(RangoPeso::class, 'rango_cod', 'cod_rango');
    }
}
