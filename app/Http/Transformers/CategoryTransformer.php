<?php

namespace App\Http\Transformers;


use League\Fractal\TransformerAbstract;
use App\Category;


class CategoryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * Transform the resource into an array.
     *
     * @param  Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->getKey(),
            'name' => $category->getAttribute('name'),
            'author_id' => $category->getAttribute('author_id'),
            'created_at' => $category->getAttribute('created_at'),

        ];
    }

    /**
     * Include Author
     *
     * @param  Category $category
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Category $category)
    {
        $user = $category->user;
        return $this->item($user, function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name
            ];
        });
    }
}
