<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
        'category_id',
        'user_id',
        'category_name',

    ];
}
