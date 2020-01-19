<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permission extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'Crear usuarios', '_module' => 4],
            ['id' => 2, 'name' => 'Visualizar usuarios', '_module' => 4],
            ['id' => 3, 'name' => 'Visualizar usuario propio', '_module' => 4],
            ['id' => 4, 'name' => 'Editar usuarios', '_module' => 4],
            ['id' => 5, 'name' => 'Editar usuario propio', '_module' => 4],
            ['id' => 6, 'name' => 'Eliminar usuarios', '_module' => 4],
        ]);
    }
}
