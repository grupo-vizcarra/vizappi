<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleApp extends Model{
    protected $table = 'modules_app';
    protected $guarded = [];

    public function permissions(){
        return $this->hasMany('App\Permission', '_module', 'id');
    }

    public function accountsVsPermissions(){
        return $this->belongsToMany('App\Account', 'accounts_has_modules_app', '_module', '_account');
    }
}