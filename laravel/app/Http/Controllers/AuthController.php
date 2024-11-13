<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthStoreRequest;
use App\Http\Requests\Auth\AuthIndexRequest;
use App\Services\UserService\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private readonly UserService $users
    ) {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthIndexRequest $request)
    {
        $data = $request->validated();


        $user = $this->users->getByLogin($data['login']);

        if (is_null($user) || ! $token = auth()->attempt([
            'phone' => $user->phone,
            'password' => $data['password']
        ])) {
            return response()->json(['message' => __("authorization.WRONG_LOGIN")], 401);
        }

        if (!$user || is_null($user->verified_at)) {
            return response()->json(['message' => __("authorization.NOT_VERIFIED")], 402);
        }

        return $this->respondWithToken($token);
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
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(true);

        return response()->json(['message' => __("authorization.LOGGED_OUT")]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(true));
    }

    public function register(AuthStoreRequest $request)
    {
        $data = $request->validated();

        $user = $this->users->create($data);

        if (!$user) {
            return response()->json(['message' => __("authorization.ERROR")], 501);
        }

        return response()->json(['message' => __("authorization.REGISTERED")]);
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
}
