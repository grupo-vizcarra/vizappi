<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPointType extends Model{
    protected $table = 'workpoints_types';
    protected $guarded = [];

    public function workpoints(){
        return $this->hasMany('App\WorkPoint', '_type', 'id');
    }
}
