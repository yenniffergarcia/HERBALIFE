<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Ciclo;
use App\Cuestionario;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	protected function credentials(Request $request)
	{
        $cuestionarios_vencidos = Cuestionario::verificarCuestionariosVencidos(date('Y-m-d'));
        $cuestionarios_publicados = Cuestionario::verificarCuestionariosPublicar(date('Y-m-d'));

        foreach ($cuestionarios_vencidos as $cuestionario) 
        {
            $cambiar = Cuestionario::findOrFail($cuestionario->id); 
            $cambiar->fkestado = $estado->id;
            $cambiar->save();
        }

        foreach ($cuestionarios_publicados as $cues) 
        {
            $cambiar = Cuestionario::findOrFail($cues->id); 
            $cambiar->fkestado = 21;
            $cambiar->save();
        }  

		$ciclo = Ciclo::where('nombre', date('Y'))->first();

		if(is_null($ciclo))
		{
			$insert = new Ciclo();
			$insert->nombre = date('Y');
			$insert->fkestado = 5;
			$insert->save();
		}

		$login = $request->input($this->username());
		$field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		return [$field => $login, 'password' => $request->input('password'), 'fkestado' => 11];
	}
}
