<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\DetalleVenta;
use App\Stock;
use App\Factura;
use Auth;

class DetalleVentaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created_pedido_monto(DetalleVenta $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)
            ->select('producto.precio as precio')->first();

        $nivel = Factura::join('persona_nivel', 'pedido.fkpersonivel', 'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel', 'nivel.id')
            ->join('descuento', 'nivel.fkdescuento', 'descuento.id')
            ->where('pedido.id', $data->fkpedido)->select('porcentaje')->first();

        $sub_total = ($stock->precio * $data->cantidad) * $nivel->porcentaje;
        $total = $stock->precio * $data->cantidad;

        $update = Factura::findOrFail($data->fkpedido);
        $update->subtotal = $sub_total + $update->subtotal;
        $update->total = $total + $update->total;
        $update->save();
    }

    public function update_pedido_monto(DetalleVenta $data)
    {
        $stock = Stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->where('stock.id', $data->fkstock)
            ->select('producto.precio as precio')->first();

        $nivel = Factura::join('persona_nivel', 'pedido.fkpersonivel', 'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel', 'nivel.id')
            ->join('descuento', 'nivel.fkdescuento', 'descuento.id')
            ->where('pedido.id', $data->fkpedido)->select('porcentaje')->first();

        $sub_total = ($stock->precio * $data->cantidad) * $nivel->porcentaje;
        $total = $stock->precio * $data->cantidad;

        $update = Factura::findOrFail($data->fkpedido);
        $update->subtotal = $update->subtotal - $sub_total;
        $update->total = $update->total - $total;
        $update->save();
    }  

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
