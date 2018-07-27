<?php

namespace App\Http\Controllers;


use App\Secret;
use App\User;
use Illuminate\Http\Request;

class ShareSecretController extends Controller
{
    /**
     * The secret repository implementation.
     *
     * @var Secret
     */
    protected $secret;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param  Secret $secret
     * @return void
     */
    public function __construct(Secret $secret, User $user)
    {
        $this->secret = $secret;
        $this->user = $user;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function share(Request $request, $id)
    {
        $secret = $this->secret->find($id);
        $this->validate($request, [
            'author_id' => 'required',
        ]);
        $user = $this->user->find($request['author_id']);
        if ($user) {
            $secret->sharedUsers()->attach($user);
            return 'success';
        } else {
            return 'uncsuccessful';
        }
    }

}
