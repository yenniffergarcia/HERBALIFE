<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Persona;
use App\User;

class AsociadoInterno
{
    public function handle($request, Closure $next)
    {
        $es_gerente = Persona::find(Auth::user()->fkpersona);
        $rol = User::where('fkpersona', $es_gerente->id_padre)->first();

        if(Auth::user()->fkrol == 3 && $rol->fkrol == 2)
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
