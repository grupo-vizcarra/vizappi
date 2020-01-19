<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPoint extends Model{
    protected $table = 'workpoints';
    protected $guarded = [];

    public function accounts(){
        return $this->hasMany('App\Account', '_state', 'id');
    }

    public function type(){
        return $this->belongsTo('App\WorkPointType', '_type');
    }
}

