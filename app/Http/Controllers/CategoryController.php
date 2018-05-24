<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\CategoryTransformer as CategoryTransformer;

// @TODO fix indentation better if you follow PSR-2 coding style... done ;)
// @TODO always remove unnecessary comments.
// @TODO  make use of laravel's fillable pattern for saving and creating resources
// @TODO it would be better if the error message are translatable
// @TODO fix doc block and try to make use of php 7.1 feature like strict types.

class CategoryController extends BaseController
{

    /**
     * The category repository implementation.
     *
     * @var CategoryRepository
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @param  Category $category
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //@TODO what if user want to paginate 20 records per page...done
        $limit = Input::get('limit');
        $categories = Category::paginate($limit);
        return $this->response->paginator($categories, new CategoryTransformer);

    }

    /**
     * Show the form for creating a new resource.
     *
     
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //@TODO create should be strtolower and avoid using static methods

//        Category::create($request->all());
        $category = $this->category->all();
        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @param int id
     */
    public function store(Request $request,$id)
    {
        //@TODO the doc block says it create the new resource but looks like it is updating to .... have a look at SOLID

        $category = $this->category->find($id);
        $category->id = $request->input('id');
        $category->name = $request->input('category_name');
        if ($category->save()) {
            //@TODO if would be better if it returns the item just created
            return $this->response->created('Category created ');
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
        // @TODO avoid using static methods..done
        $category = $this->category->find($id);
        return $this->response->item($category, new CategoryTransformer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // @TODO $id is saying why are you using me in the code....DONE

        // @TODO i don't this this action works try it. look for SOLID... looks like this action can also create new resource
//        $category = new $request->isMethod('put') ? Category::findorFail($request->id) : new Category;
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
        //        @TODO avoid using static methods...done
        $category = $this->category->find($id);
        // @TODO what if the delete fails
        if ($category->delete()) {
            return $this->response->item($category, new CategoryTransformer);
        }
    }
}

