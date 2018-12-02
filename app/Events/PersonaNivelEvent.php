<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PuntoMes;
use App\PersonaNivel;
use Auth;

class PersonaNivelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created_verificarnivel(PuntoMes $data)
    {
        if($data->punto > 500 && $data->punto < 2501)
        {
            $this->cambiar_estado_nive($data, 1, 2);
        }
        if($data->punto > 2500 && $data->punto < 4001)
        {
            $this->cambiar_estado_nive($data, 2, 3);            
        }   
        if($data->punto > 4000)
        {
            $this->cambiar_estado_nive($data, 3, 4);             
        }             
    }    

    public function update_verificarnivel(PuntoMes $data)
    {
        if($data->punto > 500 && $data->punto < 2501)
        {
            $this->cambiar_estado_nive($data, 1, 2);
        }
        if($data->punto > 2500 && $data->punto < 4001)
        {
            $this->cambiar_estado_nive($data, 2, 3);            
        }   
        if($data->punto > 4000)
        {
            $this->cambiar_estado_nive($data, 3, 4);             
        }
    }   

    public function cambiar_estado_nive($data, $numero_actual, $numero_nuevo)
    {
        $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
            ->where('fknivel', $numero_actual)
            ->select('id')->first();

        if(!is_null($cambiar_nivel))
        {
            $update = PersonaNivel::findOrFail($cambiar_nivel->id);
            $update->estado = 0;
            if($update->save())
            {
                $insert = new PersonaNivel;
                $insert->fkpersona = $data->fkpersona;
                $insert->fknivel = $numero_nuevo;
                $insert->save();
            }
        }         
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
