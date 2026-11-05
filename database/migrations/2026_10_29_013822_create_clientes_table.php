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
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('cod_cliente', 12)->primary();
            $table->string('nom_cliente', 100);
            $table->string('seg_nom_cliente', 100)->nullable();
            $table->string('ape_cliente', 100);
            $table->string('seg_ape_cliente', 100)->nullable();
            $table->string('dir_cliente', 150);
            $table->string('tel_cliente', 10);
            $table->integer('cant_env')->default(0);
            $table->foreignId('tipo_cli_cod')->constrained('tipos_cliente', 'cod_tipo_cli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
