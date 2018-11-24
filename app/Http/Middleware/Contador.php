<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use App\Sistema_Rol_Usuario;

class Contador
{
    public function handle($request, Closure $next)
    {
        $rol = Sistema_Rol_Usuario::join('sistema_rol', 'sistema_rol_usuario.fksistema_rol', 'sistema_rol.id')
            ->where('sistema_rol.fkrol', 4)
            ->where('sistema_rol_usuario.fkuser', Auth::user()->id)->first();

        if(!is_null($rol))
        {
            return redirect()->to('/500');
        }
        else
        {
            return $next($request);
        }
    }
}
