<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\JWTAuth;

class EmailLogin extends Model
{
    public $fillable = ['email', 'token'];

    public static function createForEmail($email,$token)
    {
        return self::create([
            'email' => $email,
            'token' => $token
        ]);
    }

    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-15 minutes'))
            ->firstOrFail();
    }

    public function user()
    {
        return $this->hasOne(\App\User::class, 'email', 'email');
    }
}
