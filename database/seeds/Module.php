<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Module extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('modules_app')->insert([
            ['id' => 1, 'name' => 'Tablero'],
            ['id' => 2, 'name' => 'Productos'],
            ['id' => 3, 'name' => 'Almacenes'],
            ['id' => 4, 'name' => 'Usuarios y cuentas'],
            ['id' => 5, 'name' => 'Proveedores'],
            ['id' => 6, 'name' => 'Reportes'],
            ['id' => 7, 'name' => 'Compras'],
            ['id' => 8, 'name' => 'Entradas'],
            ['id' => 9, 'name' => 'Salidas'],
            ['id' => 10, 'name' => 'Clientes'],
            ['id' => 11, 'name' => 'Crédito y Cobranza'],
        ]);
    }
}
