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
        'category'
    ];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function transform(Secret $secret)
    {
        return [
            'secret_id' => $secret->id,
            'url' => $secret->url,
            'email' => $secret->email,
            'password' => $secret->password,
        ];
    }

    /**
     * Include Author
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeCategory(Secret $secret)
    {
        $category = $secret->category;

        return $this->item($category, function($category) {
            return [
                'id' => $category->id,
                'name' => $category->category_name
            ];
        });
    }

}
