<?php

namespace App\Http\Controllers;


use App\Secret;
use Illuminate\Http\Request;
use App\Http\Resources\Secret as SecretResource;

class SecretController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('jwt-auth');
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secrets = Secret::paginate(15);

        //Return collection of category as a resource
        return SecretResource::collection($secrets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return new SecretResource($secret);
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
        return new SecretResource($secret);
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
        //
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
            return new SecretResource($secret);
        }
    }
}
