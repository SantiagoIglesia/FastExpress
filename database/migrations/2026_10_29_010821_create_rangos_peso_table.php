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
        Schema::create('rangos_peso', function (Blueprint $table) {
            $table->integer('cod_rango')->primary();
            $table->decimal('peso_min');
            $table->decimal('peso_max');
            $table->decimal('valor_peso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangos_peso');
    }
};
