<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{


    /**
     * The user repository implementation.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param  User $user
     * @return void$user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function parseEmail($email,Request $request)
    {
        dd($email);
//        $url = 'http://password-manager.local:81/login/{email}?expires=1530675985&signature=fc3369fc5518737ed48f030c83a1cebbb78c0f6ca20e562ecc31d814f2c0fddd';
//        print_r(parse_url($url));
        $user = User::query()->where('email', $request->get('email')->first());
//        return parse_url($url, PHP_URL_PATH);

     return $user;
    }
}
