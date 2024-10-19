<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DynamicDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (Session::has('dataBaseName')) {
            if (Auth::user()->rol_id==1) {
                if ($user) {
                    if ($user->company) {
                        $connection = 'dynamic_connection';
                        Config::set('database.connections.' . $connection . '.database', Session::get('dataBaseName'));
                        Config::set('database.default', $connection);
                    }
                    
                }
        
                return $next($request);
            }
        }
        
        if ($user) {
            if ($user->company) {
                $connection = 'dynamic_connection';
                Config::set('database.connections.' . $connection . '.database', $user->company->database_name);
                Config::set('database.default', $connection);
            }
            
        }

        return $next($request);
    

       
    }
}
