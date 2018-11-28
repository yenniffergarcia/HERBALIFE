<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PaqueteInicialPersona;
use App\Mes;
use App\User;
use App\PaqueteProducto;
use App\PuntoMes;
use App\PersonaNivel;
use Auth;

class PaqueteInicialPersonaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created_paquetepuntos(PaqueteInicialPersona $data)
    {
        $punteo = 0;
        setlocale(LC_TIME, 'spanish');  
        $mes_actual = strftime("%B",mktime(0, 0, 0, date('n'), 1, 2000)); 

        $mes = Mes::where('mes', $mes_actual)->first();
        $fecha = User::where('fkpersona', Auth::user()->fkpersona)->first();

        $punto_producto = PaqueteProducto::join('producto', 'paquete_producto.fkproducto', 'producto.id')
            ->where('paquete_producto.estado', 1)
            ->where('id', $data->fkpaquete_producto)
            ->select('punto')->get();

        foreach($punto_producto as $value)
        {
            $punteo = $punteo + $value->punto;
        }

        if(Auth::user()->fkrol == 3)
        {
            $insert = new PuntoMes;
            $insert->fkmes = $mes->id;
            $insert->fkpersona = Auth::user()->fkpersona;
            $insert->punto = $punteo;
            $insert->fecha = date("Y-m-d", strtotime($fecha->created_at));
            $insert->save();
        }
    }

    public function created_personanivel(PaqueteInicialPersona $data)
    {
        $persona = User::where('fkpersona', $data->fkpersona)->first();

        if(Auth::user()->fkrol != 1)
        {
            $insert = new PersonaNivel;
            $insert->fkpersona = $data->fkpersona;
            $insert->fknivel = 1;
            if($insert->save())
            {
                $update = User::findOrFail($persona->id);
                $update->estado = 1;
                $update->save();
            }            
        }        
    }   

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
