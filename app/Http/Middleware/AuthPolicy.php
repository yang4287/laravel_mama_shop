<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthPolicy
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
        if (!Session::has('name')) {
        	
        		
                if($request->is('admin/*')){ 
                    return redirect('/admin/login');
                }
                else if($request->is('member/api/*')){
                    return response()->json([
                        'status' => 'fail',
                        'msg' => '請先登入',
                    ], 200);
                }
                else{
                    return redirect('/member/login');
                }
        	
          
        }
        return $next($request);
    }
}
