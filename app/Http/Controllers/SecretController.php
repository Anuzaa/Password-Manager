<?php

namespace App\Http\Controllers;


use App\Secret;
use Illuminate\Http\Request;
use App\Http\Transformers\SecretTransformer as SecretTransformer;

class SecretController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secrets = Secret::query()->with('category')->paginate(15);

        return $this->response->paginator($secrets, new SecretTransformer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Secret::Create($request->all());
        return $this->response->created();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $secret = $request->isMethod('put') ? Secret::findOrFail($request->id) : new Secret;
        $secret->id = $request->input('id');
        $secret->url = $request->input('url');
        $secret->email = $request->input('email');
        $secret->password = Hash::make($request->input('password'));
        $secret->owner = $request->input('owner');

        if ($secret->save()) {
            return $this->response->created();
        }else{
            return $this->response->errorBadRequest();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $secret = Secret::findOrFail($id);
        return $this->response->item($secret, new SecretTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $secret = $request->isMethod('put') ? Role::findOrFail($request->id) : new Role;
        $secret->id = $request->input('id');
        $secret->url = $request->input('url');
        $secret->email = $request->input('email');
        $secret->password = Hash::make($request->input('password'));
        $secret->owner = $request->input('owner');
        $secret->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secret = Secret::findOrFail($id);

        if ($secret->delete()) {
            return $this->response->item($secret, new SecretTransformer);
        }
    }
}
