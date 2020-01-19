<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
    protected $table = 'permissions';
    protected $guarded = [];

    public function module(){
        return $this->belongsTo('App\ModuleApp', '_module');
    }

    public function accountsVsPermissons(){
        return $this->belongsToMany('App\Account', 'accounts_has_permissions', '_permission', '_account');
    }

    public function roles(){
        return $this->belongsToMany('App\Rol', 'rol_permissions_default', '_permissions', '_rol');
    }
}