<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountStatus extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('accounts_states')->insert([
            ['id' => 1, 'statename' => 'Cuenta nueva', 'description' => 'Sin inicio de sesión previa'],
            ['id' => 2, 'statename' => 'Disponible', 'description' => 'Sin sesiones activas'],
            ['id' => 3, 'statename' => 'Archivada/Bloqueada', 'description' => 'Por administrador']
        ]);
    }
}
