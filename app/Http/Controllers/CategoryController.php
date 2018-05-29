<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use App\Http\Transformers\CategoryTransformer;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->category->with('secret')->paginate($request->query('per_page'));

        return $this->response->paginator($categories, new CategoryTransformer);
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
        $category = $request->validate([
            'category_name' => 'required',
        ]);
        $this->category->create($request->only('category_name'));
        return $this->response->collection($category, new CategoryTransformer)->setStatusCode(200);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->category->find($id)->secret;
        if (!$category) {
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
        $category = $this->category->find($id);
        $this->validate($request, [
            'category_name' => 'required'
        ]);
        if ($this->category->save($category, $request->all())) {
            $this->response->item($category, new CategoryTransformer)->setStatusCode(200);
        } else {
            $this->response->error('Category could not be updated', 500);
        }
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        if ($category->delete()) {
            $this->response->item($category, new CategoryTransformer);
        } else {
            $this->response->error('Category could not be deleted', 500);
        }
        return $category;
    }
}


