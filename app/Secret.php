<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    protected $fillable=[
        'secret_id',
        'user_id',
        'category_id',
        'url',
        'user_name',
        'password',
        'owner'


    ];
}
