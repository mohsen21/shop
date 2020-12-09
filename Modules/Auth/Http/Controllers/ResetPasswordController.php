<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use const App\Providers\HTTP_OK;

/**
 * @group Auth_ResetPassword
 */
class ResetPasswordController extends Controller
{

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $response = ['message' => "Password reset successful"];
        return response($response, HTTP_OK);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $response = ["message" => "Token Invalid"];
        return response($response, HTTP_UNAUTHORIZED);
    }
}
