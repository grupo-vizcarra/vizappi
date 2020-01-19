<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLogType extends Model{
    protected $table = 'account_log_types';
    protected $guarded = [];
    
    public function logs(){
        return $this->hasMany('App\AccountLog', '_log_type', 'id');
    }
}