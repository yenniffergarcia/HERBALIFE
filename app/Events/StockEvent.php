<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\DetalleCarga;
use App\DetalleVenta;
use App\Stock;
use Auth;

class StockEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created(Stock $data)
    {

    }

    public function updated(Stock $data)
    {

    } 

    public function created_carga(DetalleCarga $data)
    {
        $existe = Stock::where('fkpersona', Auth::user()->fkpersona)
            ->where('fkproducto', $data->fkproducto)
            ->where('fecha_vencimiento', date("Y-m-d", strtotime($data->fecha_vencimiento)))
            ->select('id')->first();

        if(!\is_null($existe)) {
            $insert = Stock::findOrFail($existe->id);
            $insert->cantidad = $insert->cantidad + $data->cantidad;
            $insert->save();
        }
        else {
            $insert = new Stock;
            $insert->fkpersona = Auth::user()->fkpersona;
            $insert->fkproducto = $data->fkproducto;
            $insert->cantidad = $data->cantidad;
            $insert->fecha_vencimiento = $data->fecha_vencimiento;
            $insert->save();
        }
    }

    public function updated_carga(DetalleCarga $data)
    {
        $existe = Stock::where('fkpersona', Auth::user()->fkpersona)
            ->where('fkproducto', $data->fkproducto)
            ->where('fecha_vencimiento', date("Y-m-d", strtotime($data->fecha_vencimiento)))
            ->select('id')->first();

        if(!\is_null($existe)) {
            $insert = Stock::findOrFail($existe->id);
            $insert->cantidad = $insert->cantidad - $data->cantidad;
            $insert->save();
        }
    } 

    public function created_venta(DetalleVenta $data)
    {
        $insert = Stock::findOrFail($data->fkstock);
        $insert->cantidad = $insert->cantidad - $data->cantidad;
        $insert->save();
    }

    public function updated_venta(DetalleVenta $data)
    {
        $insert = Stock::findOrFail($data->fkstock);
        $insert->cantidad = $insert->cantidad + $data->cantidad;
        $insert->save();
    }     

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
