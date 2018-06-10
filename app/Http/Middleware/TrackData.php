<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;

use Auth;

class TrackData
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
        if(Auth::guest()) {
          $user = DB::table('users')->where('id', '=', '1')->get()->first();
          session()->put('user', $user);
        } else {
          session()->put('user', Auth::user());
        }

        !session()->has('ip') ? session()->put('ip', \Request::ip()) : '';
        return $next($request);
    }
}
