<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\CategoryTransformer as CategoryTransformer;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @var Category
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
        $limit = Input::get('limit');
        $categories = $this->category->paginate($limit);
        return $this->response->paginator($categories,  new CategoryTransformer)->setStatusCode(200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @param int id
     */
    public function store(Request $request)
    {
        $this->category->create($request->only('category_name'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->category->find($id);
        if (!$category){
            throw new NotFoundHttpException('Category not found');
        }
        return $this->response->item($category, new CategoryTransformer)->setStatusCode(200);
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
//        dd($request->all());
        $category = $this->category->find($id);
        if (!$category){
            throw new NotFoundHttpException('Category not found');
        }
        if ($this->category->save($request->all())) {
            return $this->response->noContent();
        } else{
            return $this->response->error('Category could not be updated');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        if (!$category)
            throw new NotFoundHttpException('Category not found');
        if ($category->delete()) {
            return $this->response->noContent();
        } else {
            return $this->response->error('Category could not be deleted', 500);
        }
    }
}

