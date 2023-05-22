<?php

namespace App\Http\Middleware;

use Closure;

class ChangePassword
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
        $user = $request->user();
        
        if($user->pwd_changed==0){
            return redirect()->route('changepwd');
        }
        
        return $next($request);
    }
    

}
