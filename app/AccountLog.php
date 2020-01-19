<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model{
    protected $table = 'account_log';
    protected $guarded = [];

    public function type(){
        return $this->belongsTo('App\AccountTypeLog', '_log_type');
    }

    public function from(){

    }

    public function to(){

    }
}