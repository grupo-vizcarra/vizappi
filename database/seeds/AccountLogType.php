<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AccountLogType extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('account_log_types')->insert([
            ['id' => 1, 'name' => 'Creación'],
            ['id' => 2, 'name' => 'Edición'],
            ['id' => 3, 'name' => 'Archivado'],
        ]);
    }
}
