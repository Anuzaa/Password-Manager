<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareSecretController extends Controller
{
    /**
     * The secret repository implementation.
     *
     * @var Secret
     */
    protected $secret;

    /**
     * Create a new controller instance.
     *
     * @param  Secret $secret
     * @return void
     */
    public function __construct(Secret $secret)
    {
        $this->secret = $secret;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $users = $this->user->get();
        return $this->response->collection($users, new UserTransformer);
    }


    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'author_id' => 'required',
            'secret_id' => 'required'

        ]);
        $secret = $this->secret->newInstance($request->all());

        $secret->forceFill(['author_id' => $request->user()->id]);
        if ($secret->save()) {
            $author_id = $request->user()->id;
            $secret->sharedUsers()->sync($author_id);

        }
    }
}
