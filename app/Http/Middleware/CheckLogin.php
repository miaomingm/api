<?php

namespace App\Http\Middleware;
use Closure;

class CheckLogin
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
        //判断用户是否登录
        $user_id=session('user_id');
        if(!$user_id){
            return redirect("user/login")->with("msg","请先登录");
        }
        return $next($request);
    }
}
