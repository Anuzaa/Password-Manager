<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Transformers\RoleTransformer as RoleTransformer;

class RoleController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::query()->paginate(15);

        //Return collection of role as a resource
        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Role::Create($request->all());
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
        $role = $request->isMethod('put') ? Role::findOrFail($request->id) : new Role;
        $role->id = $request->input('id');
        $role->name = $request->input('role_name');

        if ($role->save()) {
            return $this->response->created();
        } else {
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
        $role = Role::findOrFail($id);
        return new $this->response->item($role, new RoleTransformer);
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = $request->isMethod('put') ? Role::findOrFail($request->id) : new Role;
        $role->id = $request->input('id');
        $role->name = $request->input('role_name');
        $role->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->delete()) {
            return $this->response->item($role, new RoleTransformer);
        }
    }
}

