<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Gerente
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->fkrol == 2)
        {
            flash('¡Sin Privilegios!')->error()->important();
            return redirect()->to('/');
        }
        else
        {
            return $next($request);
        }
    }
}
