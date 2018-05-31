<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    protected $fillable=[
        'id',
        'url',
        'name',
        'email',
        'password',
    ];

  public function category()
  {
       return $this->belongsTo(Category::class);
   }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
