<?php

namespace App\Http\Middleware;

use Closure;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((auth('api')->user() && auth('api')->user()['permission'] == 0)||
            (auth('web')->user() && auth('web')->user()['permission'] == 0)) {
            return $next($request);
        } else if (auth('web')->user() && auth('web')->user()['permission'] == 0) {
            return $next($request);
        } else if (auth('web')->user()) {
            return redirect('');
        }
        return response()->json([
            'status' => false,
            'message' => [
                'permission' => 'permission error'
            ]
        ], 403);
    }
}
