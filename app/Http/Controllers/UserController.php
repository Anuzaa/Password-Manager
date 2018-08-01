<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Transformers\UserTransformer;
use Illuminate\Http\Request;


class UserController extends Controller
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
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->user->where('id','!=', $request->user()->id)->get();
        return $this->response->collection($users, new UserTransformer);
    }

    public function register(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',


        ]);
        $user = $this->user->newInstance($request->all());

        $user->password = encrypt(request('password'));
        $user->save();


    }
}
