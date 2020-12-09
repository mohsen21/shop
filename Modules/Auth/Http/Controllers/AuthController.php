<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserStoreRequest;
use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use const App\Providers\HTTP_OK;
use const App\Providers\HTTP_UNPROCESSABLE_ENTITY;

/**
 * @group  Auth_Auth
 *
 * APIs for managing Degree Doctor
 */
class AuthController extends Controller
{

    /**
     * Store a User by mobile and password.
     * @param UserStoreRequest $request
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam email string
     * @bodyParam mobile string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * @bodyParam gender string required
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(UserStoreRequest $request)
    {
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, HTTP_OK);
    }
    /**
     * login user by mobile.
     * @bodyParam mobile string required .
     * @bodyParam password string required .
     * @param UserLoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, HTTP_OK);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * logout user by token.
     * @authenticated
     * @param UserLoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, HTTP_OK);
    }



}
