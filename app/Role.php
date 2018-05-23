<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=[
        'role_id',
        'user_id',
        'category_id',
        'role_name',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
