<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Rol extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Super Administrador'],
            ['id' => 2, 'name' => 'Administrador'],
            ['id' => 3, 'name' => 'Bodeguero'],
            ['id' => 4, 'name' => 'Vendedor'],
            ['id' => 5, 'name' => 'Repartidor'],
        ]);
    }
}
