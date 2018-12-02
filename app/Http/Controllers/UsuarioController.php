<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        $this->middleware('gerente');
        $this->middleware('asociado_interno');
        $this->middleware('asociado_externo');
    }

    public function index()
    {
        return view('mantenimiento.usuario.index');
    }

    public function getdata()
    {
        $query = User::join('persona', 'users.fkpersona', 'persona.id')
            ->join('rol', 'users.fkrol', 'rol.id')
            ->select(['nombre1', 'nombre2', 'apellido1', 'apellido2', 'apellido3', 'rol.nombre as rol',
            'users.email as email', 'users.estado as estado']);

        return Datatables::of($query)
            ->addColumn('persona', function ($data) {
                return $data->nombre1.' '.$data->nombre2.' '.$data->apellido1.' '.$data->apellido2.' '.$data->apellido3;
            })
            ->addColumn('estado', function ($data) {
                if($data->estado == 1)
                {
                    return "Activo";
                }
                else
                {
                    return "Inactivo";                    
                }
            })->make(true);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
     
    }

    public function destroy($id)
    {
      
    }
  
}