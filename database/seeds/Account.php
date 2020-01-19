<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Account extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        /*DB::table('accounts')->insert([
            ['id' => 1, 
            'nick' => 'Carlos', 
            'password' => Hash::make('12345'), 
            'picture' => null, 
            'names' => 'J. Carlos', 
            'surname_pat' => 'Hernández', 
            'surname_mat' => 'Contreras', 
            'created_at' => new Datetime,
            'updated_at' => new Datetime,
            '_current_workpoint' => 1,
            '_state' => 1]
        ]);*/
        $modules = DB::table('modules_app')->get();
        $permissions = DB::table('permissions')->get();
        $rowModules = [];
        $rowPermissions = [];
        foreach($modules as $module){
            array_push($rowModules, ['_account' => 1, '_module' => $module->id]);
        }

        foreach($permissions as $permission){
            array_push($rowPermissions, ['_account' => 1, '_permission' => $permission->id]);
        }

        DB::table('accounts_has_modules_app')->insert($rowModules);
        DB::table('accounts_has_permissions')->insert($rowPermissions);
    }
}
