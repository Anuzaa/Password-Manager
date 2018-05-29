<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Transformers\RoleTransformer ;

class RoleController extends BaseController
{
    /**
     * The category repository implementation.
     *
     * @var Role
     */
    protected $role;

    /**
     * Create a new controller instance.
     *
     * @param  Role $role
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd('asd');
        $roles = $this->role->paginate($request->query('per_page'));
        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @param int id
     */
    public function store(Request $request)
    {
        $role = $request->validate([
            'role_name' => 'required',
        ]);
        $this->role->create($request->only('role_name'));
        return $this->response->collection($role, new RoleTransformer)->setStatusCode(200);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->role->find($id);
        if (!$role) {
            throw new NotFoundHttpException('Role not found');
        }
        return $this->response->item($role, new RoleTransformer)->setStatusCode(200);
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
//        dd($request->all());
        $role = $this->role->find($id);
        $this->validate($request, [
            'category_name' => 'required'
        ]);
        if ($this->role->save($role, $request->all())) {
            $this->response->item($role, new RoleTransformer)->setStatusCode(200);
        } else {
            $this->response->error('Role could not be updated', 500);
        }
        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->role->find($id);
        if ($role->delete()) {
            $this->response->item($role, new RoleTransformer);
        } else {
            $this->response->error('Role could not be deleted', 500);
        }
        return $role;
    }
}

