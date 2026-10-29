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
        Schema::create('tipos_cliente', function (Blueprint $table) {
            $table->integer('cod_tipo_cli')->primary();
            $table->string('nom_tipo_cli', 100);
            $table->decimal('porc_descuento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cliente');
    }
};
