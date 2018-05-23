<?php

namespace App\Http\Transformers;


use Dingo\Api\Transformer\Adapter\Fractal;
use League\Fractal\TransformerAbstract;
use App\Category;


class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'category_id' => $category->id,
            'category_name' => $category->category_name,

        ];
    }
}
