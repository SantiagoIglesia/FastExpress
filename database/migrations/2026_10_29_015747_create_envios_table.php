<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id('cod_envio');
            $table->dateTime('fecha_envio', 0);
            $table->decimal('peso_envio', 5, 2);
            $table->decimal('tarifa_base_envio', 10, 2);
            $table->decimal('costo_peso_envio', 10, 2);
            $table->decimal('subtotal_envio', 10, 2);
            $table->decimal('porc_desc_envio', 5, 2);
            $table->decimal('valor_desc_envio', 10, 2);
            $table->decimal('porc_rec_envio', 5, 2);
            $table->decimal('valor_rec_envio', 10, 2);
            $table->decimal('total_envio', 10, 2);
            $table->string('cliente_cod', 12);
            $table->foreign('cliente_cod')->references('cod_cliente')->on('clientes');
            $table->foreignId('estado_cod')->constrained('estados_envio', 'cod_estado');
            $table->foreignId('tipo_env_cod')->constrained('tipos_envio', 'cod_tipo_env');
            $table->foreignId('rango_cod')->nullable()->constrained('rangos_peso', 'cod_rango')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
