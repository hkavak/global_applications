<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Lang;

class LocaleMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
  
        $locale = Session::get('application_locale');

        App::setLocale($locale);
        Lang::setFallback($locale);

        return $next($request);
    }

}
