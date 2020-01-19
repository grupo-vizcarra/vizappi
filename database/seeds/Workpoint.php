<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Workpoint extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('workpoints')->insert([
            ['id' => 1, 'fullname' => 'San Pablo', 'alias' => 'CDSSAP', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 1],
            ['id' => 2, 'fullname' => 'Pantaco', 'alias' => 'CDSPAN', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 1],
            ['id' => 3, 'fullname' => 'Bolivia', 'alias' => 'CDSBOL', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 1],
            ['id' => 4, 'fullname' => 'San Pablo Uno', 'alias' => 'SP1', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 5, 'fullname' => 'San Pablo Dos', 'alias' => 'SP2', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 6, 'fullname' => 'Correo Uno', 'alias' => 'CO1', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 7, 'fullname' => 'Correo Dos', 'alias' => 'CO2', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 8, 'fullname' => 'Apartado Uno', 'alias' => 'AP1', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 9, 'fullname' => 'Apartado Dos', 'alias' => 'AP2', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 10, 'fullname' => 'Ramon Corona Uno', 'alias' => 'RC1', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 11, 'fullname' => 'Ramon Corona Dos', 'alias' => 'RC2', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
            ['id' => 12, 'fullname' => 'Brasil', 'alias' => 'BRA', 'updated_at' => new DateTime, 'created_at' => new DateTime, '_type' => 2],
        ]);
    }
}
