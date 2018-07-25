<?php

namespace App\Http\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{



    /**
     * Transform the resource into an array.
     *
     *
     * @param  User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->getKey(),
            'name' => $user->getAttribute('name'),
            'email' => $user->getAttribute('email'),
            'password' => $user->getAttribute('password'),
            'created_at' => $user->getAttribute('created_at'),
        ];
    }


}
