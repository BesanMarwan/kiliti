<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class Jsonify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        $lang = $request->header('language');
        if ($lang) {
            if($lang == 'en'){
                \App::setLocale($lang);
            }else{
                \App::setLocale('ar');
            }
        }else{
            \App::setLocale('ar');
        }
//        return redirect()->route('api.down');
        return $next($request);


    }
}
