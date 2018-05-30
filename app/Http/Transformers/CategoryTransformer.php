<?php

namespace App\Http\Transformers;


use App\Secret;
use League\Fractal\TransformerAbstract;
use App\Category;


class CategoryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
//    protected $defaultIncludes = [
//        'secret'
//    ];

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
    public function includeSecret(Category $category)
    {
        $secret = $category->secret;

        return $this->item($secret, function ($secret) {
            return [
                'id' => $secret->id,
                'email' => $secret->email,
                'password' => $secret->password
            ];
        });
    }
}
