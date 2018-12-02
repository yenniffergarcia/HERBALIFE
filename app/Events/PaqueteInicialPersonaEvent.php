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
use App\Stock;
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

        $paquete = PaqueteProducto::find($data->fkpaquete_producto);
        $punto_producto = PaqueteProducto::join('producto', 'paquete_producto.fkproducto', 'producto.id')
            ->where('paquete_producto.estado', 1)
            ->where('paquete_producto.fkpaquete', $paquete->fkpaquete)
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
            $existe = PersonaNivel::where('fkpersona', $data->fkpersona)
                ->where('fknivel', 1)->first();

            if(is_null($existe))
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
    }   

    public function created_produtostock(PaqueteInicialPersona $data)
    {
        $fecha = date('Y-m-d');
        $masmes = strtotime ( '+12 month' , strtotime ( $fecha ) ) ;
        $masmes = date ( 'Y-m-d' , $masmes );

        $paquete = PaqueteProducto::find($data->fkpaquete_producto); 

        $productos = PaqueteProducto::where('fkpaquete', $paquete->fkpaquete)
            ->select('paquete_producto.*')->get();

        foreach ($productos as $producto) 
        {
            $existe = Stock::where('fkpersona', $data->fkpersona)
                    ->where('fkproducto', $producto->fkproducto)
                    ->where('fecha_vencimiento', $masmes)
                    ->first();

            if(!is_null($existe))
            {
                $update = Stock::findOrFail($existe->id);
                $update->cantidad = $update->cantidad+1;
                $update->save();
            }
            else
            {
                $insert = new Stock;
                $insert->fkpersona = $data->fkpersona;
                $insert->fkproducto = $producto->fkproducto;
                $insert->cantidad = 1;
                $insert->fecha_vencimiento = $masmes;
                $insert->save();
            }

        }
    } 

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
