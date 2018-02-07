<?php

namespace App\Http\Middleware;

use App\User;
use JWTAuth;
use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->toUser();

            if ($user instanceof User) {
                return $next($request);
            }
        } catch (\Exception $e) {

            return response_error($e->getMessage(), [], 401);
        }

        return response([], 401);

    }
}
