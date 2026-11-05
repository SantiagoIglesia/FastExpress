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
        if (DB::table('parametros')->exists()) {
            return; // ya sembrado
        }
        
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
            ['peso_min' => 0.01, 'peso_max' => 5.00,  'valor_peso' => 2.00],
            ['peso_min' => 5.01, 'peso_max' => 20.00, 'valor_peso' => 4.00],
        ]));

        DB::table('estados_envio')->insert($this->conFechas([
            ['nom_estado' => 'COTIZADO'],
            ['nom_estado' => 'REGISTRADO'],
            ['nom_estado' => 'RECHAZADO'],
        ]));

        $tipo = fn (string $nombre) => DB::table('tipos_cliente')
            ->where('nom_tipo_cli', $nombre)
            ->value('cod_tipo_cli');

        DB::table('clientes')->insert($this->conFechas([
            [
                'cod_cliente'     => '10234567',      // 8 caracteres (límite inferior)
                'nom_cliente'     => 'Carlos',
                'seg_nom_cliente' => 'Andrés',
                'ape_cliente'     => 'Ramírez',
                'seg_ape_cliente' => 'Gómez',
                'dir_cliente'     => 'Calle 45 # 12-30, Bogotá',
                'tel_cliente'     => '3101234567',
                'cant_env'        => 0,
                'tipo_cli_cod'    => $tipo('NUEVO'),
            ],
            [
                'cod_cliente'     => '1012345678',    // 10 caracteres
                'nom_cliente'     => 'María',
                'seg_nom_cliente' => null,
                'ape_cliente'     => 'López',
                'seg_ape_cliente' => 'Pérez',
                'dir_cliente'     => 'Carrera 7 # 80-15, Bogotá',
                'tel_cliente'     => '3209876543',
                'cant_env'        => 0,
                'tipo_cli_cod'    => $tipo('FRECUENTE'),
            ],
            [
                'cod_cliente'     => '123456789012',  // 12 caracteres (límite superior)
                'nom_cliente'     => 'Laura',
                'seg_nom_cliente' => 'Sofía',
                'ape_cliente'     => 'Martínez',
                'seg_ape_cliente' => null,
                'dir_cliente'     => 'Avenida 6N # 25-40, Cali',
                'tel_cliente'     => '3004567890',
                'cant_env'        => 0,
                'tipo_cli_cod'    => $tipo('VIP'),
            ],
            [
                'cod_cliente'     => '52987654321',   // 11 caracteres
                'nom_cliente'     => 'Juan',
                'seg_nom_cliente' => 'David',
                'ape_cliente'     => 'Torres',
                'seg_ape_cliente' => 'Rojas',
                'dir_cliente'     => 'Calle 10 # 4-22, Medellín',
                'tel_cliente'     => '3152223344',
                'cant_env'        => 0,
                'tipo_cli_cod'    => $tipo('VIP'),
            ],
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
