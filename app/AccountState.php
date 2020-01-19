<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountState extends Model{
    protected $table = 'accounts_states';
    protected $guarded = [];

    public function accounts(){
        return $this->hasMany('App\Account', '_state', 'id');
    }
}
