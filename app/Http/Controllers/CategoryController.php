<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use App\Http\Transformers\CategoryTransformer as CategoryTransformer;

class CategoryController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(15);

        //Return collection of category as a resource
        return $this->response->paginator($categories, new CategoryTransformer);

//        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Category::Create($request->all());
        return $this->response->created();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->isMethod('put') ? Category::findorFail($request->id) : new Category;
        $category->id = $request->input('id');
        $category->name = $request->input('category_name');
        if($category->save()) {
            return $this->response->created();
            } else {
            return $this->response->errorBadRequest();

    }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //Get article
        $category = Category::findOrFail($id);
//        dd($category->toArray());
//        dd(new CategoryResource($category));

        //Return single category as a resource

        return $this->response->item($category,new CategoryTransformer);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $category=new $request->isMethod('put') ? Category::findorFail($request->id) : new Category;
        $category->id = $request->input('id');
        $category->name = $request->input('category_name');

        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get category
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            return $this->response->item($category, new CategoryTransformer);
        }
    }
}

