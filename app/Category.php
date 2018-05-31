<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
    ];
    public function secrets(){
        return $this->hasMany(Secret::class, 'category_id');

    }

//    public function secrets()
//    {
//        return $this->hasMany(Secret::class);
//    }

//    protected $table='categories';
//
//
}
