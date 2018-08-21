<?php

namespace App\Http\Transformers;

use App\Secret;
use League\Fractal\TransformerAbstract;

class SecretTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'category'
    ];


    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'category',
        'user'

    ];


    /**
     * Transform the resource into an array.
     *
     *
     * @param  Secret $secret
     * @return array
     */
    public function transform(Secret $secret)
    {
//        dd($secret->sharedUsers);
        return [
            'id' => $secret->getKey(),
            'url' => $secret->getAttribute('url'),
            'name' => $secret->getAttribute('name'),
            'email' => $secret->getAttribute('email'),
             'password' => $secret->getAttribute('password'),
            'author_id' => $secret->getAttribute('author_id'),
            'category_id' => $secret->getAttribute('category_id'),
            'created_at' => $secret->getAttribute('created_at'),
//             'sharedUser' => $secret->sharedUsers->pluck('email')
        ];
    }

    /**
     * Include Author
     *
     * @param  Secret $secret
     * @return \League\Fractal\Resource\Item
     */
    public function includeCategory(Secret $secret)
    {
        $category = $secret->category;

        return $this->item($category, function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name
            ];
        });
    }
    /**
     * Include Author
     *
     * @param  Secret $secret
     * @return \League\Fractal\Resource\Item
     */

    public function includeUser(Secret $secret)
    {
//        dd($secret->sharedUsers);
        $user = $secret->user;
//        return $user;
        return $this->item($user, function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name
            ];
        });
    }


//    /**
//     * Include Author
//     *
//     * @param  Secret $secret
//     * @return \League\Fractal\Resource\Item
//     */
//
//    public function includesharedSecret(Secret $secret)
//    {
//        $user = $secret->user;
//        return $this->item($user, function ($user) {
//            return [
//                'id' => $user->id,
//                'name' => $user->name
//            ];
//        });
//    }

}
