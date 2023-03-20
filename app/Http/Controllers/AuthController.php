<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthService;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\UserRegister\UserRegisterService;

class AuthController extends Controller
{
    /**
     * instance AuthService
     *
     * @var [AuthService]
     */
    public $authService;

    /**
     * insance UserRegisterService
     *
     * @var [UserRegisterService]
     */
    public $userRegisterService;

    /**
     * init class
     */
    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userRegisterService = new UserRegisterService();
    }

    /**
     * login user with email and password
     * * 200 => [access_token, authenticated]
     * * 200 => [message, authenticated]
     * * 403 => [authenticated, error_message]
     * * 422 => error validator [message, errors=>nameinput]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        // validator request
        $validate = $request->validated();
        // get user
        $user = User::where('email', $validate['email'])->first();

        // is email verified
        /* comment this "if", if is not email verified
        if ($user->email_verified_at == null) {
            return $this->authService->accessTokenVerified($user, $validate['password']);
        }*/

        // is not email verified
        return $this->authService->accessToken($user, $validate['password']);
    }

    /**
     * create new user with role
     * * 200 => [access_token, authenticated]
     * * 200 => [message, authenticated]
     * * 403 => [authenticated, error_message]
     * * 422 => error validator [message, errors=>nameinput]
     * [* 401 => [message]] if protected with middleware
     *
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        // validator request
        $validate = $request->validated();
        // create user with role 
        $user = $this->userRegisterService->registerUser($validate);

        // is email verified return json [authenticated => false, message]
        return $this->authService->accessTokenVerified($user, $validate['password']);

        // is not email verified return json [access_token, authenticated]
        //return $this->authService->accessToken($user, $validate['password']);
    }

    /**
     * verified if user token is valide and return value of user
     * * 200 => [user]
     * * 401 => [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifiedAuth(Request $request): JsonResponse
    {
        // get user with role
        $user = User::find($request->user()->id);
        $user->picture;
        return response()->json(['user' => $user, 'authenticated' => true]);
    }

    /**
     * verified email and markEmailAsVerified for user
     * * redirect in to login page of front
     *
     * @param Request $request
     * @return void
     */
    public function verifiedAuthEmail(Request $request)
    {
        $user = User::findOrFail($request->id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return request()->wantsJson()
                ? new JsonResponse('', 204)
                : redirect(url(env('APP_FRONT_URL_LOGIN')));
        }

        return request()->wantsJson()
            ? new JsonResponse('', 204)
            : redirect(url(env('APP_FRONT_URL_LOGIN')));
    }

    /**
     * delete access_token
     * * 200 => [authenticated]
     * * 401 => [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // delete access_token en cours
        $request->user()->tokens()->delete();
        return response()->json(['authenticated' => false], 200);
    }
}
