<?php

namespace App\Http\Transformers;


use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform the resource into an array.
     *
     * @param  Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'role_id' => $role->id,
            'role_name' => $role->role_name,
        ];
    }
}
