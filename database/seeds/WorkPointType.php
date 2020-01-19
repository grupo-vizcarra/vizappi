<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WorkPointType extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('workpoints_types')->insert([
            ['id' => 1, 'name' => 'Centro de distribución'],
            ['id' => 2, 'name' => 'Sucursal']
        ]);
    }
}
