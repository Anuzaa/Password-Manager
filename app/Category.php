<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scopeisAvailable($query)
    {
        return $query->where('name','Facebook');
    }

    protected $fillable = [
        'name',
    ];



    public function secrets()
    {
        return $this->hasMany(Secret::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


}
