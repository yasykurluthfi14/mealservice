<?php

namespace App\Http\Middleware;

use Closure;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LockMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = CRUDBooster::myId();
        $user = DB::table('cms_users')->where('id',$user_id)->first();
        if ($user->lock == 1 && $user->id_cms_privileges==3) {
            return redirect('/admin/lock-screen');
        }
        return $next($request);
    }
}
