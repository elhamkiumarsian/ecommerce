<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];

    protected $fillable = [
        'id',
        'name',
        'type',
        'desc',
        'parent',
        'price',
        'pic'
    ];

    public function options(){
      return $this->hasMany(self::class,'parent','id');
    }
    public function allOptions(){
        $options=$this->options;
        if (empty($options)) {
            return $options;
        }
        foreach($options as $option){
            $test=$option->load('options');
            $options = $options->merge($option->allOptions());
        }
        return $options;
    }
}
