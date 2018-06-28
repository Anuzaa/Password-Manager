<?php

namespace App\Http\Controllers;


use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;



class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     * @param \Illuminate\Http\Request $request
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return $this->response->json(compact('token'));


    }

    public function login(Request $request)
    {
//        $this->validate($request, ['email' => 'required|email|exists:users']);
//
//        $emailLogin = EmailLogin::createForEmail($request->only('email'));

        $url = URL::signedRoute('sign-email', ['email' => 'anuja.bhattarai@introcept.co']);
        $to = 'anuja.bhattarai@introcept.co';
        $this->mail($url, $to);
        return 'Login email sent. Go check your email.';
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }


    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to re-login to get a new token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        JWTAuth::invalidate($request->input('token'));
        return response([
            'status' => 'success',
            'msg' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);
    }

    public function mail(string $url, string $to)
    {
        Mail::to($to)->send(new SendMailable($url));
        return 'success';
    }


}
