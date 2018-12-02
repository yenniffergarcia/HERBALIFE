<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\PagoAsociado;
use App\Bonificacion;
use App\Regalia;
use App\Persona;

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
		$monto_total = 0;
		$ultimo_dia = date("d",(mktime(0,0,0,date('n')+1,1,date('Y'))-1));

		if($ultimo_dia == date('d'))
		{
			$personas = Persona::where('id_padre', !=, 0)->get();

			foreach ($personas as $persona) 
			{
				$pagado = PagoAsociado::where('fkpersona', $persona->id)
					->where('fkmes', date('n'))->where('anio', date('Y'))->first();

				if(is_null($pagado))
				{
					$monto_bonificacion = Bonificacion::where('fkpersona', $persona->id)
						->where('fkmes', date('n'))->where('anio', date('Y'))->first();

					if(!is_null($monto_bonificacion))
					{
						$monto_total = $monto_bonificacion->monto;
					}

					$monto_regalia = Regalia::where('fkpersona', $persona->id)
						->where('fkmes', date('n'))->where('anio', date('Y'))->first();

					if(!is_null($monto_regalia))
					{
						$monto_total = $monto_total + $monto_bonificacion->monto;
					}
					
					if($monto_total > 0)
					{
						$insert = new PagoAsociado;
						$insert->fkpersona = $persona->id;
						$insert->fkmes = date('n');
						$insert->monto = $monto_total;
						$insert->anio = date('Y');
						$insert->save();
					}
				}
			}

		}

		$login = $request->input($this->username());
		$field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		return [$field => $login, 'password' => $request->input('password'), 'estado' => 1];
	}
}
