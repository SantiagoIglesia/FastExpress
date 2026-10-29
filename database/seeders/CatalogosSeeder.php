<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parametros')->insert($this->conFechas([
            ['nom_param' => 'TARIFA_BASE', 'valor' => 5.00],   // BR-01
            ['nom_param' => 'PESO_MAX',    'valor' => 20.00],  // BR-02
        ]));

        DB::table('tipos_cliente')->insert($this->conFechas([
            ['nom_tipo_cli' => 'NUEVO',     'porc_descuento' => 0],   // BR-03
            ['nom_tipo_cli' => 'FRECUENTE', 'porc_descuento' => 10],
            ['nom_tipo_cli' => 'VIP',       'porc_descuento' => 20],
        ]));

        DB::table('tipos_envio')->insert($this->conFechas([
            ['nom_tipo_env' => 'ESTANDAR', 'porc_recargo' => 0],      // BR-04
            ['nom_tipo_env' => 'EXPRESS',  'porc_recargo' => 25],
        ]));

        // Rangos: (0.00, 5.00] y (5.00, 20.00]; peso_min exclusivo, peso_max inclusivo
        DB::table('rangos_peso')->insert($this->conFechas([
            ['peso_min' => 0.00, 'peso_max' => 5.00,  'valor_peso' => 2.00],
            ['peso_min' => 5.00, 'peso_max' => 20.00, 'valor_peso' => 4.00],
        ]));

        DB::table('estados_envio')->insert($this->conFechas([
            ['nom_estado' => 'COTIZADO'],
            ['nom_estado' => 'REGISTRADO'],
            ['nom_estado' => 'RECHAZADO'],
        ]));
    }

    private function conFechas(array $filas): array
    {
        $ahora = now();

        return array_map(
            fn ($fila) => $fila + ['created_at' => $ahora, 'updated_at' => $ahora],
            $filas
        );
    }
}
