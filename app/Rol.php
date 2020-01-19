<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model{
    protected $table = 'roles';
    protected $guarded = [];

    public function accounts(){
        return $this->hasMany('App\Account', '_rol', 'id');
    }

    public function permissions(){
        return $this->belongsToMany('App\Permission', 'rol_permissions_default', '_rol', '_permission');
    }
}