<?php

namespace App\Http\Controllers;


use App\Secret;
use Illuminate\Http\Request;
use App\Http\Transformers\SecretTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SecretController extends BaseController
{
    /**
     * The category repository implementation.
     *
     * @var Secret
     */
    protected $secret;

    /**
     * Create a new controller instance.
     *
     * @param  Secret $secret
     * @return void
     */
    public function __construct(Secret $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $secret=Secret::find();
//        $secret->sharedUsers()->sync([3]);
//        dd($secret->sharedUsers);
////        dd($request->user()->id);
        $secrets = $this->secret->where('author_id', $request->user()->id)->get();

        return $this->response->collection($secrets, new SecretTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user, $author_id)
    {
//        dd($request->all());
        $this->validate($request, [
            'url' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'category_id'=>'required'

        ]);
        $secret = $this->secret->newInstance($request->all());
        $secret->password= encrypt(request('password'));

        $secret->forceFill(['author_id' => $request->user()->id]);

         $secret->sharedUsers()->save($user);
         return $secret;
// {
//            $secret->sharedUsers()->sync([$author_id]);
//            $this->response->item($secret->refresh(), new SecretTransformer)->setStatusCode(200);
//            return 'success';
//        }
//
//        return $this->response->error("Secret could not be created");

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
        $secret = $this->secret->where('author_id', $request->user()->id)->find($id);
        if (!$secret) {
            throw new NotFoundHttpException('Secret not found');
        }
        return $this->response->item($secret, new SecretTransformer)->setStatusCode(200);
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
        $secret = $this->secret->find($id);
        $validatedData = $this->validate($request, [
            'url' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (!$secret) {
            throw new NotFoundHttpException();
        }
        if ($secret->fill($validatedData)->save()) {
            $this->response->item($secret->fresh(), new SecretTransformer)->setStatusCode(200);
            return "Successfully updated secret";
        }
        return $this->response->error('Secret could not be updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $secret = $this->secret->where('author_id', $request->user()->id)->find($id);
        if ($secret->delete()) {
            $this->response->noContent();
            return "Successfully deleted secret";
        } else {
            return $this->response->error('Secret could not be deleted');
        }

    }
}
