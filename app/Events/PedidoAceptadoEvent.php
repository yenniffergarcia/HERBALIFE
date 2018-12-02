<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PedidoAceptado;
use App\Stock;
use App\Factura;
use App\Persona;
use App\PersonaNivel;
use App\PuntoMes;
use App\Regalia;

class PedidoAceptadoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created_aceptadoproducto(PedidoAceptado $data)
    {
        $stock = Stock::find($data->fkstock);

        if(!is_null($stock))
        {
            $update = Stock::findOrFail($data->fkstock);
            $update->cantidad = $update->cantidad - $data->cantidad;
            $update->save();
        }
    }

    public function created_llenarinventario(PedidoAceptado $data)
    {
        $stock = Stock::find($data->fkstock);
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();

        $existe_stock = Stock::where('fkproducto', $stock->fkproducto)
            ->where('fkpersona', $persona->id)->first();

        if(!is_null($existe_stock))
        {
            $update = Stock::findOrFail($existe_stock->id);
            $update->cantidad = $update->cantidad + $data->cantidad;
            $update->save();
        }
        else
        {
            $fecha = date('Y-m-d');
            $masmes = strtotime ( '+12 month' , strtotime ( $fecha ) ) ;
            $masmes = date ( 'Y-m-d' , $masmes );

            $insert = new Stock;
            $insert->fkpersona = $persona->id;
            $insert->fkproducto = $stock->fkproducto;
            $insert->fecha_vencimiento = $masmes;
            $insert->cantidad = $data->cantidad;
            $insert->save();            
        }
    }

    public function created_sumarpuntos(PedidoAceptado $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)->select('punto')->first();
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();            

        if(!is_null($stock))
        {
            $punto = PuntoMes::where('fkmes', date('n'))
                ->where('fkpersona', $persona->id)
                ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
                ->first();

            if(!is_null($punto))
            {
                $update = PuntoMes::findOrFail($punto->id);
                $update->punto = $update->punto + ($data->cantidad * $stock->punto);
                $update->save();
            }
            else
            {
                $insert = new PuntoMes;
                $insert->fecha = date('Y-m-d');
                $insert->punto = $data->cantidad * $stock->punto;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id;
                $insert->save();
            }
        }
    }  

    public function created_verficarregalias(PedidoAceptado $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)->select('precio')->first();        
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();  
        $cincuenta = PersonaNivel::where('fkpersona', $persona->id)
            ->where('fknivel', 4)->where('estado', 1)->first();          

        if(!is_null($cincuenta))
        {
            $existe_regalia = Regalia::where('fkpersona', $pedido->fkpersona)
                ->where('fkpedido', $data->fkpedido)
                ->where('fkmes', date('n'))
                ->where('anio', date('Y'))->first();

            if(!is_null($existe_regalia))
            {
                $update = Regalia::findOrFail($existe_regalia->id);
                $update->monto = $update->monto + ($stock->precio * 0.05);
                $update->save();
            }
            else
            {
                $insert = new Regalia;
                $insert->monto = $stock->precio * 0.05;
                $insert->fkpersona = $pedido->fkpersona;
                $insert->fkcodigo = $pedido->fkcodigo;
                $insert->fkmes = date('n');
                $insert->fkpedido = $data->fkpedido;
                $insert->save();
            }
        }
    }    

    public function deleting_regresionstock(PedidoAceptado $data)
    {
        $stock_asociado = Stock::find($data->fkstock);

        if(!is_null($stock_asociado))
        {
            $update = Stock::findOrFail($data->fkstock);
            $update->cantidad = $update->cantidad + $data->cantidad;
            $update->save();
        }

        $stock = Stock::find($data->fkstock);
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();

        $existe_stock = Stock::where('fkproducto', $stock->fkproducto)
            ->where('fkpersona', $persona->id)->first();

        if(!is_null($existe_stock))
        {
            $update = Stock::findOrFail($existe_stock->id);
            $update->cantidad = $update->cantidad - $data->cantidad;
            $update->save();
        }
    }   

    public function deleting_regresionpuntos(PedidoAceptado $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)->select('punto')->first();
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();            

        if(!is_null($stock))
        {
            $punto = PuntoMes::where('fkmes', date('n'))
                ->where('fkpersona', $persona->id)
                ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
                ->first();

            if(!is_null($punto))
            {
                $update = PuntoMes::findOrFail($punto->id);
                $update->punto = $update->punto - ($data->cantidad * $stock->punto);
                $update->save();
            }
        }
    }          

    public function deleting_regresionregalias(PedidoAceptado $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)->select('precio')->first();        
        $pedido = Factura::find($data->fkpedido);
        $persona = Persona::where('codigo', $pedido->fkcodigo)->first();  
        $cincuenta = PersonaNivel::where('fkpersona', $persona->id)
            ->where('fknivel', 4)->where('estado', 1)->first();          

        if(!is_null($cincuenta))
        {
            $existe_regalia = Regalia::where('fkpersona', $pedido->fkpersona)
                ->where('fkpedido', $data->fkpedido)
                ->where('fkmes', date('n'))
                ->where('anio', date('Y'))->first();

            if(!is_null($existe_regalia))
            {
                $update = Regalia::findOrFail($existe_regalia->id);
                $update->monto = $update->monto - ($stock->precio * 0.05);
                $update->save();
            }
        }
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
