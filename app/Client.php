<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function services(){
        return $this->hasMany('App\Service');
    }

    public function getName(){
        return $this->name;
    }
}
