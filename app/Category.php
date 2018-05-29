<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'category_name',
        'secret_id'
    ];

    public function secrets()
    {
        return $this->hasMany(Secret::class);
    }

//    protected $table='categories';
//
//    public function owner(){
//        return $this->hasOne('Category','user_id');
//    }
}
