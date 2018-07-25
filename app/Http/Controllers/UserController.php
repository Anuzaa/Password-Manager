<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Transformers\UserTransformer;


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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->get();
        return $this->response->collection($users, new UserTransformer);
    }

    public function register(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',


        ]);
        $user = $this->user->newInstance($request->all());
        $user->password = encrypt(request('password'));
        if($user->save()){
            $this->response->item($user->refresh(), new UserTransformer)->setStatusCode(201);
            return 'Successfully created user';
        }


    }
}
