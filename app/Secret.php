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
        'category_id'
    ];


  public function category()
  {
       return $this->belongsTo(Category::class, 'category_id','id');
   }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id','id');
    }
}
