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
        $secrets = $this->secret->with('category')->paginate($request->query('per_page'));

        return $this->response->paginator($secrets, new SecretTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $secret = $request->validate([
            'url' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $this->secret->create($request->all());
        return $this->response->collection($secret, new SecretTransformer)->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $secret = $this->secret->find($id);
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
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($this->secret->save($secret, $request->all())) {
            $this->response->item($secret, new SecretTransformer)->setStatusCode(200);
        } else {
            $this->response->error('Secret could not be updated', 500);
        }
        return $secret;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secret = $this->secret->find($id);
        if ($secret->delete()) {
            $this->response->item($secret, new SecretTransformer);
        } else {
            $this->response->error('Secret could not be deleted', 500);
        }
        return $secret;
    }
}
