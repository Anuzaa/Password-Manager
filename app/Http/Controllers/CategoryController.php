<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use App\Http\Transformers\CategoryTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
        $categories = $this->category->where('author_id', $request->user()->id)->get();

        return $this->response->collection($categories, new CategoryTransformer);
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
        $this->validate($request, [
            'name' => 'required',
        ]);
        $category = $this->category->newInstance($request->only('name'));
        $category->forceFill(['author_id' => $request->user()->id]);

        if ($category->save()) {
            $this->response->item($category->refresh(), new CategoryTransformer)->setStatusCode(201);
            return 'Successfully created category';
        } else {
            return $this->response->error("Category could not be created", 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $category = $this->category->where('author_id', $request->user()->id)->find($id);
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
        $validatedData = $this->validate($request, [
            'name' => 'required'
        ]);
        if (!$category) {
            throw new NotFoundHttpException('Category not found');
        }


        if ($category->fill($validatedData)->save()) {
            $this->response->item($category->fresh(), new CategoryTransformer)->setStatusCode(200);
            return "Successfully updated category";
        }

        return $this->response->error('Category could not be updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $category = $this->category->where('author_id', $request->user()->id)->find($id);
            if (!$category) {
                throw new NotFoundHttpException('Category not found');
            }
            if ($category->delete()) {
                $this->response->noContent();
                return "Successfully deleted category";
            } else {
                return "Unsuccessfull";
            }
        } catch (\Exception $e) {
            return "Category is in use";
        }
    }
}


