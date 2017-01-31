<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','address','phone'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function items(){
        return $this->hasMany('App\Item','order_id');
    }
}
