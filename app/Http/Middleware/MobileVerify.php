<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Models\User;
use const App\Providers\HTTP_BAD_REQUEST;
use const App\Providers\HTTP_UNAUTHORIZED;

class MobileVerify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user=$request->user();

        if(!$user->mobile_verify){

            return response(['message' => trans('message.auth.mobile_not_valid')],HTTP_UNAUTHORIZED);

        }

        return $next($request);
    }
}
