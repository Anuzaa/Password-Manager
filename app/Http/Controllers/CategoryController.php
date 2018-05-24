<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use App\Http\Transformers\CategoryTransformer as CategoryTransformer;

// @TODO fix indentation better if you follow PSR-2 coding style... done ;)
// @TODO always remove unnecessary comments.
// @TODO  make use of laravel's fillable pattern for saving and creating resources
// @TODO it would be better if the error message are translatable
// @TODO fix doc block and try to make use of php 7.1 feature like strict types.

class CategoryController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //@TODO what if user want to paginate 20 records per page

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
        //@TODO create should be strtolower and avoid using static methods
        Category::create($request->all());
        return $this->response->created();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //@TODO the doc block says it create the new resource but looks like it is updating to .... have a look at SOLID

        $category = $request->isMethod('put') ? Category::findorFail($request->id) : new Category;
        $category->id = $request->input('id');
        $category->name = $request->input('category_name');
        if ($category->save()) {
            //@TODO if would be better if it returns the item just created
            return $this->response->created();
        } else {
            //@TODO Looks like it should be internal server error

            return $this->response->errorBadRequest();

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //Get article
//        @TODO avoid using static methods
        $category = Category::findOrFail($id);
//        dd($category->toArray());
//        dd(new CategoryResource($category));

        //Return single category as a resource

        return $this->response->item($category, new CategoryTransformer);
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
        // @TODO $id is saying why are you using me in the code....

        // @TODO i don't this this action works try it. look for SOLID... looks like this action can also create new resource
        $category = new $request->isMethod('put') ? Category::findorFail($request->id) : new Category;
        $category->id = $request->input('id');
        $category->name = $request->input('category_name');

        // @TODO what if the save fails
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //        @TODO avoid using static methods

        //Get category
        $category = Category::findOrFail($id);
        // @TODO what if the delete fails

        if ($category->delete()) {
            return $this->response->item($category, new CategoryTransformer);
        }
    }
}

