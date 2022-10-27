<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Closure;
use App\Models\Role;

class CheckRole
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

        $routeName=Route::getFacadeRoot()->current()->uri();

        $route=explode('/',$routeName);

        $roleRoutes=Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray();
        if (auth()->check()) {
            if(!in_array($route[0],$roleRoutes)){
                return $next($request);
            }else{
                if($route[0] != auth()->user()->roles->first()->allowed_route){
                    $path= $route[0] != auth()->user()->roles->first()->allowed_route ? $route[0].'.login':auth()->user()->roles->first()->allowed_route.'.index';
                    return redirect()->route($path);
                }else{
                  return $next($request);  
                }
            }
        }else{
            $routeDistination=in_array($route[0],$roleRoutes) ? $route[0].'.login' : 'login';
            $path= $route[0] != '' ? $routeDistination : auth()->user()->roles->first()->allowed_route . '.index';
            return redirect()->route($path);

        }
        return $next($request);
    }
}
