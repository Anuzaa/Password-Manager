<?php

namespace App\Http\Controllers;


use App\Secret;
use Illuminate\Http\Request;
use App\Http\Transformers\SecretTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SecretController extends BaseController
{
    /**
     * The secret repository implementation.
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

        $secrets = $request->user()->sharedSecrets()
            ->leftJoin('categories', 'categories.id', 'secrets.category_id')
            ->leftJoin('users', 'users.id', 'secrets.author_id')
            ->when($request->has('keywords'), function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $keyword = $request->get('keywords');
                    $query->where('categories.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('url', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('secrets.name', 'LIKE', '%' . $keyword . '%')
                        ->groupBy('secrets.id');

                });
            })->paginate(5);
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
//        dd($request->all());
        $this->validate($request, [
            'url' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'category_id' => 'required'
        ]);
        $secret = $this->secret->newInstance($request->all());
        $secret->password = encrypt(request('password'));
        $secret->forceFill(['author_id' => $request->user()->id]);
        if ($secret->save()) {
            $author_id = $request->user()->id;
            $secret->sharedUsers()->attach($author_id);
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
        $secret = $this->secret->find($id);
        $author_id = $request->user()->id;
        if ($author_id) {
            $secret->sharedUsers()->detach($author_id);
            $secret->delete();
            return 'Successfully deleted secrets';
        } else {
            return 'uncsuccessful';
        }
    }
}
