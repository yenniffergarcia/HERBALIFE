<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\User;
use App\Persona;
use App\Email;
use App\Estado;
use App\Sistema_Rol_Usuario;

class UsuarioController extends Controller
{
    protected $verificar_insert =
    [
        'email' => 'required|max:75',
        'fkrol' => 'required',   
        'fkpersona' => 'required|integer',                                    
    ];

    protected $verificar_update =
    [
        'username' => 'required|max:50',
        'email' => 'required|email|max:75', 
        'password' => 'required',
        'fkpersona' => 'required|integer',      
        'fkestado' => 'required|integer',    
    ];    

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
        //$this->middleware('director', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
        //$this->middleware('secretaria', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
        $this->middleware('contador', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
        $this->middleware('catedratico', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
        $this->middleware('alumno', ['only' => ['index', 'store', 'update', 'cambiarEstado']]);
    }

    public function index()
    {
        return view('UsuarioSistema/usuario');
    }

    public function getdata()
    {
        $query = User::dataUsuario();
        return Datatables::of($query)->make(true);
    }

    public function droppersona(Request $request, $id)
    {
        if($request->ajax()){
            $data = Persona::buscarEstadoPersona($id);
            return response()->json($data);
        }        
    }    

    public function dropemail(Request $request, $id)
    {
        if($request->ajax()){
            $data = Email::buscarEmailPersona($id);
            return response()->json($data);
        }        
    }  

    public function existeuser(Request $request, $id)
    {
        if($request->ajax()){
            $data = User::existeUsuario($id);
            return response()->json($data);
        }        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $existe = User::existeUsuario($request->fkpersona);

        if($existe->count() < 1)
        {
            $estado = Estado::buscarIDEstado(12);
            $token = "IMEDCHI-".str_random(6)."!";

            $validator = Validator::make(Input::all(), $this->verificar_insert);
            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
            } else {
                //Generar usuario
                $persona = Persona::buscarIDPersona($request->fkpersona);
                $nombre_completo = $persona->nombre1.' '.$persona->nombre2.' '.$persona->nombre3.' '.$persona->apellido1.' '.$persona->apellido2.' '.$persona->apellido3;
                $incial_nombre1 =  substr($persona->nombre1, 0, 1);
                if($persona->nombre2 != null){
                    $incial_nombre2 = substr($persona->nombre2, 0, 1);
                    $username = strtolower(str_replace(' ', '',trim($incial_nombre1.$incial_nombre2.$persona->apellido1)));
                }else{
                    $incial_apellido2 = substr($persona->apellido2, 0, 1);
                    $username = strtolower(str_replace(' ', '',trim($incial_nombre1.$incial_apellido2.$persona->apellido1)));                
                } 

                $buscar_existe_alumno = User::where('username', $username)->first();

                if(!is_null($buscar_existe_alumno))
                {
                    do{

                        $numero = rand(1,100);

                        $username = $username.$numero;

                        $buscar_existe_alumno = User::where('username', $username)->first();

                    }while(!is_null($buscar_existe_alumno));   
                }      

                $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
                $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
                
                $username = str_replace($no_permitidas, $permitidas ,$username);                

                $insert = new User();
                $insert->username = $username;
                $insert->email = $username."@imedchi.edu.gt";      
                $insert->token = $token; 
                $insert->password = bcrypt("@dM1nIStR4t0r");
                $insert->fkpersona = $request->fkpersona;                                  
                $insert->fkestado = $estado->id;
                $insert->save();

                $this->enviarEmail($request->email, $nombre_completo, $username, $token);
            }
        } 
        
        $user = User::buscarIDUsuario($request->fkpersona);

        foreach ($request->fkrol as $rol) {
            $insert = new Sistema_Rol_Usuario();
            $insert->fksistema_rol = $rol;
            $insert->fkuser = $user->id;      
            $insert->save();
        }

        return response()->json($insert);       
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
        $validator = Validator::make(Input::all(), $this->verificar_update);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $cambiar = User::findOrFail($id);  
            $cambiar->username = $request->username;
            $cambiar->email = $request->email;      
            $cambiar->password = $request->password;
            $cambiar->token = $request->token; 
            $cambiar->password = bcrypt($request->password);
            $cambiar->fkpersona = $request->fkpersona;   
            $cambiar->save();
            return response()->json($cambiar);
        }        
    }

    public function cambiarEstado(Request $request)
    {
        if($request->estado == "activo")
            $estado = Estado::buscarIDEstado(12);
        else
            $estado = Estado::buscarIDEstado(11);

        $cambiar = User::findOrFail($request->pkprofesion); 
        $cambiar->fkestado = $estado->id;
        $cambiar->save();
        return response()->json($cambiar);          
    }

    public function destroy($id)
    {
      
    }

    public static function enviarEmail($correo, $persona, $usuario, $token)
    {
        $email = $correo;
        $data = array(
          'title' => "Bienvenido",
          'persona' => $persona,
          'user' => "Su usuario es: ".$usuario." y su email es: ".$usuario."@imedchi.edu.gt",
          'confirmation' => " se le ha creado una cuenta en el Sistema IMEDCHI y es necesario que confirme su Correo Electrónico y el siguiente",
          'token' => "Código: " . $token,
          'link' => "Ingresar al Siguiente LINK:  http://167.99.237.41/usuario/reset/password/confirmar"
        );
        Mail::send('emails.correo_bienvenida', $data, function ($message) use ($email){
            $message->subject('Confirmar Cuenta');
            $message->to($email);
        });        
    }    
}