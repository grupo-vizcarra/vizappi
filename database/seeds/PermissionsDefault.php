<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PermissionsDefault extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $permissions = DB::table('permissions')->get();
        $rows = [];
        foreach ($permissions as $permission){
            array_push($rows, ['_rol' => 1, '_permission' =>$permission->id]);
        }
        DB::table('rol_permissions_default')->insert($rows);
    }
}
