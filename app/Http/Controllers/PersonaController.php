<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Persona;
use App\Departamento;
use App\User;
use Auth;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $verificar_insert =
    [
        'nombre1' => 'required|max:50',
        'nombre2' => 'max:50',
        'apellido1' => 'required|max:50',
        'apellido2' => 'max:50',    
        'apellido3' => 'max:50', 
        'direccion' => 'required|max:100',  
        'email' => 'required|email|max:100|unique:persona',                     
        'fkdepartamento' => 'required|integer',  
    ];

    public function index()
    {
        return view('sistema.persona.index');
    }

    public function indexAdmin()
    {
        return view('sistema.persona.indexAdmin');
    }    

    public function getdataAdmin()
    {
        $query = persona::join('departamento', 'persona.fkdepartamento' ,'departamento.id')
            ->leftJoin('users', 'persona.id' ,'users.fkpersona')
            ->select(['persona.id as id', 'nombre1', 'nombre2', 'apellido1', 
            'apellido2', 'apellido3', 'codigo', 'direccion', 'persona.email as email', 'id_padre',
            'fkdepartamento', 'departamento.nombre as departamento', 'username', 'persona.estado as estado']);

        return Datatables::of($query)
            ->addColumn('persona', function ($data) {
                return $data->nombre1.' '.$data->nombre2.' '.$data->apellido1
                        .' '.$data->apellido2.' '.$data->apellido3;
            }) 
            ->addColumn('residencia', function ($data) {
                return $data->departamento.', '.$data->direccion;
            })    
            ->addColumn('cargo', function ($data) {
                
                $cargo = "";
                $total = 0;

                $personas = persona::where('id_padre', $data->id)->get();

                foreach($personas as $persona)
                {
                    $total = $total+1;
                    $cargo = $cargo.' - '.$total.'.'.$data->nombre1.' '.$data->nombre2.' '.$data->apellido1
                    .' '.$data->apellido2.' '.$data->apellido3;
                }

                return $cargo;
            })                    
            ->addColumn('action', function ($data) {
                $btn_estado = '';

                if($data->estado == 0)
                {
                    $btn_estado = '<button class="alta-modal btn btn-primary btn-xs" 
                    type="button" data-id="'.$data->id.'">Activar</button>';
                }

                return $btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }    

    public function getdata()
    {
        $query = persona::join('departamento', 'persona.fkdepartamento' ,'departamento.id')
            ->leftJoin('users', 'persona.id' ,'users.fkpersona')
            ->where('persona.estado', 1)
            ->where('persona.id_padre', Auth::user()->fkpersona)
            ->select(['persona.id as id', 'nombre1', 'nombre2', 'apellido1', 
            'apellido2', 'apellido3', 'codigo', 'direccion', 'persona.email as email',
            'fkdepartamento', 'departamento.nombre as departamento', 'username']);

        return Datatables::of($query)
            ->addColumn('persona', function ($data) {
                return $data->nombre1.' '.$data->nombre2.' '.$data->apellido1
                        .' '.$data->apellido2.' '.$data->apellido3;
            }) 
            ->addColumn('residencia', function ($data) {
                return $data->departamento.', '.$data->direccion;
            })                        
            ->addColumn('action', function ($data) {

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-nombre1="'.$data->nombre1.'" data-nombre2="'.$data->nombre2.'" 
                data-apellido1="'.$data->apellido1.'" data-apellido2="'.$data->apellido2.'"  
                data-apellido3="'.$data->apellido3.'" data-codigo="'.$data->codigo.'"
                data-direccion="'.$data->direccion.'" data-email="'.$data->email.'"
                data-fkdepartamento="'.$data->fkdepartamento.'" data-email="'.$data->email.'">Editar</button>';           

                return $btn_edit.'  '.$btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = persona::find($id);
            return response()->json($data);
        }        
    }  

    public function dropDepartamento(Request $request)
    {
        if($request->ajax()){
            $data = departamento::where('estado', 1)->select('departamento.*')->get();
            return response()->json($data);
        }        
    }    

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->verificar_insert);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = new persona;
            $data->nombre1 = $request->nombre1;
            $data->nombre2 = $request->nombre2;
            $data->apellido1 = $request->apellido1;     
            $data->apellido2 = $request->apellido2;                      
            $data->apellido3 = $request->apellido3;
            $data->codigo = $this->crearCodigo();
            $data->direccion = $request->direccion;
            $data->id_padre = Auth::user()->fkpersona;     
            $data->email = $request->email;                      
            $data->fkdepartamento = $request->fkdepartamento;            
            $data->save();
            return response()->json($data);
        } 
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
        $validator = Validator::make(Input::all(),        
        [
            'nombre1' => 'required|max:50',
            'nombre2' => 'max:50',
            'apellido1' => 'required|max:50',
            'apellido2' => 'max:50',    
            'apellido3' => 'max:50', 
            'direccion' => 'required|max:100',  
            'email' => 'required|email|max:100|unique:persona,email,'.$request->id,                     
            'fkdepartamento' => 'required|integer',     
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = persona::findOrFail($request->id);
            $data->nombre1 = $request->nombre1;
            $data->nombre2 = $request->nombre2;
            $data->apellido1 = $request->apellido1;     
            $data->apellido2 = $request->apellido2;                      
            $data->apellido3 = $request->apellido3;
            $data->direccion = $request->direccion;     
            $data->email = $request->email;                      
            $data->fkdepartamento = $request->fkdepartamento;           
            $data->save();
            return response()->json($data);
        }
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = persona::findOrFail($request->id);
            $data->estado = 0;
            if($data->save())
            {
                $usuario = User::where('fkpersona', $request->id)->first();
                if(!is_null($usuario))
                {
                    $usuario->estado = 0;
                    $usuario->save();
                }
            }
            return response()->json($data);
        }        
    } 

    public function estadoAdmin(Request $request)
    {
        if($request->ajax()){
            $data = persona::findOrFail($request->id);
            $data->estado = 1;
            if($data->save())
            {
                $usuario = User::where('fkpersona', $request->id)->first();
                if(!is_null($usuario))
                {
                    $usuario->estado = 1;
                    $usuario->save();
                }
            }
            return response()->json($data);
        }        
    }     

    public function destroy($id)
    {

    }

    public static function crearCodigo()
    {
        $correlativo = 0;
        $incial =  'HER';

        $persona = persona::orderby('codigo','DESC')->take(1)->first();

        if(!is_null($persona)) {
            $correlativo = substr($persona->codigo, 4, 7);
            $numero=$correlativo+1;
        }
        else {
            $numero=1;
        }        

        if($numero > 999999){
            $correlativo = $numero;
        } 
        if($numero > 99999){
            $correlativo = "0" . $numero;
        } 
        if($numero > 9999){
            $correlativo = "00" . $numero;
        } 
        if($numero > 999){
            $correlativo = "000" . $numero;
        }        
        if($numero > 99){
            $correlativo = "0000" . $numero;
        }       
        if($numero > 9){
            $correlativo = "00000" . $numero;
        }                            
        if ($numero>0 && $numero<10) {
            $correlativo = "000000" . $numero;
        }

        return strtoupper($incial.'-'.$correlativo);
    }    
}
