<?php

namespace App\Http\Middleware;

use Closure;

class AccountVerify
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
        
        if($user->account_verify==0){
            return redirect()->route('account-verify');
        }
        
        return $next($request);
    }
    

}
