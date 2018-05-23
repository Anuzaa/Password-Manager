<?php

namespace App\Http\Transformers;


use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
//    protected $availableIncludes = [
//        'category'
//    ];
//    /**
//     * List of resources possible to include
//     *
//     * @var array
//     */
//    protected $defaultIncludes = [
//        'category'
//    ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'role_id' => $role->id,
            'role_name' => $role->role_name,
        ];
    }
    /**
     * Include Author
     *
     * @return \League\Fractal\Resource\Item
     */
//    public function includeCategory(Role $role)
//    {
//        $category = $role->category;
//
//        return $this->item($category, function($category) {
//            dd($category);
//            return [
//                'id' => $category->id,
//                'name' => $category->category_name
//            ];
//        });
//    }
}
