<?php

namespace cms\Http\Middleware;

use Closure;
use DB;
use Auth;

class AdminAuth
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
        if (Auth::guard('admin')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['code'=>401,'msg'=>'該頁面不見了']);
            } else {
                return redirect()->guest('/admins/account/login');
            }
        }
        return $next($request);
    }
}
