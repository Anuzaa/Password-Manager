<?php

namespace App\Http\Controllers;


use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;


class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Routing\Route|object|string
     */
    public function authenticate(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $email = $request->route('email');
        $user = User::query()->firstOrNew(['email' => $email]);
        $token = JWTAuth::fromUser($user);
//        $new_token = JWTAuth::refresh($token);
        return redirect('/#/verify?token=' . $token)->with(compact('token'));


    }

    public function login(Request $request)

    {

        $this->validate($request, ['email' => 'required']);
        $url = URL::temporarySignedRoute('sign-email', now()->addDays(1), [
            'user' => $request->get('email'),
        ]);
        $to = $request->get('email');
        $this->mail($url, $to);
        return 'Login email sent. Go check your email.';
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
     * Refresh the token
     *
     * @return mixed
     */
    public function refresh()
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return $this->response->errorMethodNotAllowed('Token not provided');
            }
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                $refreshedToken = JWTAuth::refresh($token);
                return $this->response->withArray(['token' => $refreshedToken]);
            } catch (JWTException $e) {
                return $this->response->errorInternal('Not able to refresh Token');
            }
        }
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


    public function mail(string $url, string $to)
    {
        Mail::to($to)->send(new SendMailable($url));
        return 'success';
    }


}
