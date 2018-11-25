<?php

namespace App\Events;

use Illuminate\Support\Facades\Mail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Persona;
use App\User;

class PersonaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }
    
    public function created(Persona $data)
    {
        $nombre_completo = $data->nombre1.' '.$data->nombre2.' '.$data->nombre3.' '.$data->apellido1.' '.$data->apellido2.' '.$data->apellido3;
        $incial_nombre1 =  substr($data->nombre1, 0, 1);

        if($data->nombre2 != null){
            $incial_nombre2 = substr($data->nombre2, 0, 1);
            $username = strtolower(str_replace(' ', '',trim($incial_nombre1.$incial_nombre2.$data->apellido1)));
        }else{
            $incial_apellido2 = substr($data->apellido2, 0, 1);
            $username = strtolower(str_replace(' ', '',trim($incial_nombre1.$incial_apellido2.$data->apellido1)));                
        } 

        $exite = User::where('username', $username)->first();

        if(!is_null($exite))
        {
            do{

                $numero = rand(1,100);

                $username = $username.$numero;

                $exite = User::where('username', $username)->first();

            }while(!is_null($exite));   
        }      

        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        
        $username = str_replace($no_permitidas, $permitidas ,$username);

        $insert = new User();
        $insert->username = $username;
        $insert->email = $data->email;
        $insert->fkpersona = $data->id;
        $insert->password = \bcrypt($username);
        if($insert->save())
        {
            $this->enviarEmail($data->email, $nombre_completo, $username);
        }
    }

    public static function enviarEmail($correo, $persona, $usuario)
    {
        $email = $correo;
        $data = array(
          'title' => "Bienvenido",  
          'persona' => $persona,
          'user' => "Su usuario es: ".$usuario." y su email es: ".$email,
          'confirmation' => " se le ha creado una cuenta en el Sistema Herbalife su contraseña es, ",
          'token' => "Password: " . $usuario,
        );
        Mail::send('emails.correo_bienvenida', $data, function ($message) use ($email){
            $message->subject('Confirmar Cuenta');
            $message->to($email);
        });        
    } 

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
