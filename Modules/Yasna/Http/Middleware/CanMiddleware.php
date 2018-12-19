<?php

namespace Modules\Yasna\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permit, $role = 'admin')
    {
        $condition = user()->as($role)->can($permit);

        if (!$condition) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return new Response(view('yasna::errors.403'));
            }
        }


        return $next($request);
    }
}
