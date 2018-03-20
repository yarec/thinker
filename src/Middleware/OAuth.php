<?php

namespace Thinker\Middleware;

use Closure;
use Thinker\Facades\UCenter;

class OAuth
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
        $oauth = UCenter::webAuth();

        if ($code = $request->code) {
            $oauth->user($code)->login();
            return redirect($request->session()->get('pre_auth_url'));
        }

        if (!auth()->check()) {
            $this->flashCurrentRequest($request);
            return $oauth->redirect();
        }

        return $next($request);
    }

    protected function flashCurrentRequest($request)
    {
        $request->session()->flash(
            'pre_auth_url', 
            $request->url()
        );
    }

}
