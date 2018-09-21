<?php

namespace App\Http\Middleware;

use Closure;
use App\Action;


class PageVisit
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
        if ( 
            (strpos($request->url(), 'admin') === false) && 
            (strpos($request->url(), 'request') === false) &&
            ($request->get('ref') != 'console')
        ) {
            Action::create([
                'type'    => 'visit',
                'url'     => $request->path(),
                'visitor' => $request->ip()
            ]);
        }

        return $next($request);
    }
}
