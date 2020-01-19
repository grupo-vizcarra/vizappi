<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Account extends Model{
    protected $table = 'accounts';
    //protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = ['password'];

    public function state(){
        return $this->belongsTo('App\AccountState', '_state');
    }

    public function rol(){
        return $this->belongsTo('App\Rol', '_rol');
    }

    public function modules(){
        return $this->belongsToMany('App\ModuleApp', 'accounts_has_modules_app', '_account', '_module');
    }

    public function permissions(){
        return $this->belongsToMany('App\Permission', 'accounts_has_permissions', '_account', '_permission');
    }

    //Relación entre los puntos de trabajo y las cuentas

    public function workpoint(){
        return $this->belongsTo('App\WorkPoint', '_current_workpoint');
    }

    public function account_log_to(){
        return $this->hasMany('App\AccountLog', '_accto', 'id');
    }

    public function account_log_from(){
        return $this->hasMany('App\AccountLog', '_accfrom', 'id');
    }
}
