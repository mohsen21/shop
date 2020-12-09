<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Auth\Http\Requests\MobileStoreRequest;
use Modules\Auth\Library\Facade;
use Modules\Auth\Models\User;
use function PHPUnit\Framework\isNull;
use const App\Providers\HTTP_BAD_REQUEST;
use const App\Providers\HTTP_OK;

/**
 * @group Auth_Mobile
 */
class MobileController extends Controller
{
    /**
     * register user by mobile.
     * @param MobileStoreRequest $request
     * @bodyParam mobile string required .
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(MobileStoreRequest $request)
    {

        $user = User::where(['mobile' => $request->mobile])->first();
        if (!$user) {
            // new user
            $user = User::create($request->toArray());
        }
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token, 'status' => 'new', 'message' => trans('message.auth.mobile_code')];
        $randomCode = Facade::getInstance()->generateMobileVerifyCodeRandom();
        $user->mobile_verify_code = $randomCode;
        $user->update();
        return response($response, HTTP_OK);

    }

    /**
     * check verify mobile code
     * @param Request $request
     * @authenticated
     * @bodyParam code string
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function checkVerifyCode(Request $request)
    {
        $user = Auth::user();
        if ($request->code == $user->mobile_verify_code) {
            $user->mobile_verify = true;
            $user->save();
            $response = ['message' => trans('message.Auth.auth.mobile_code_success')];
            $status = HTTP_OK;

        } else {
            $status = HTTP_BAD_REQUEST;
            $response = ['message' => trans('message.Auth.auth.mobile_code_fail')];
        }

        return response($response, $status);
    }

    /**
     * retry generate code for mobile.
     * @param Request $request
     * @authenticated
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function retryGenerateCode(Request $request)
    {
        $user = Auth::user();
        $user->mobile_verify_code = Facade::getInstance()->generateMobileVerifyCodeRandom();
        $user->save();
        return response(['message' => trans('message.auth.mobile_retry_code_send')], HTTP_OK);
    }
}
