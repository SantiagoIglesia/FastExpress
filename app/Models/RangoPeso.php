<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RangoPeso extends Model
{
    protected $fillable = [
        'peso_min', 'peso_max', 'valor_peso'
    ];

    protected $table = 'rangos_peso';

    protected $primaryKey = 'cod_rango';

    protected $casts = [
        'peso_min'      => 'decimal:2',
        'peso_max'      => 'decimal:2',
        'valor_peso'    => 'decimal:2'
    ];

    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'rango_cod', 'cod_rango');
    }
}
