<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        /*'App\Events\CreatedTipoEmailEvent' => [
            'App\Listeners\CreatedTipoEmailListener',
        ],  */ 
        
        // ------- Eventos (Triggers), para las acciones en el modelo Persona --------
        'persona.created' => [
            'App\Events\PersonaEvent@created',
        ], 
        
        // ------- Eventos (Triggers), para las acciones en el modelo DetallePersona --------
        'detallecarga.created' => [
            'App\Events\DetalleCargaEvent@created',
        ],  
        'detallecarga.updated' => [
            'App\Events\DetalleCargaEvent@updated',
        ],

        // ------- Eventos (Triggers), para las acciones en el modelo Stock --------
        'stock.created' => [
            'App\Events\StockEvent@created',
        ],  
        'stock.updated' => [
            'App\Events\StockEvent@updated',
        ],        
        'stock_carga.created' => [
            'App\Events\StockEvent@created_carga',
        ],  
        'stock_carga.updated' => [
            'App\Events\StockEvent@updated_carga',
        ],
        'stock_venta.created' => [
            'App\Events\StockEvent@created_venta',
        ],  
        'stock_venta.updated' => [
            'App\Events\StockEvent@updated_venta',
        ],        

        // ------- Eventos (Triggers), para las acciones en el modelo PaqueteInicialPersona --------
        'paque_puntos.created' => [
            'App\Events\PaqueteInicialPersonaEvent@created_paquetepuntos',
        ],  
        'paquete_nivel.created' => [
            'App\Events\PaqueteInicialPersonaEvent@created_personanivel',
        ],  
        'produtostock.created' => [
            'App\Events\PaqueteInicialPersonaEvent@created_produtostock',
        ],              

        // ------- Eventos (Triggers), para las acciones en el modelo DetalleVenta --------
        'pedido_monto.created' => [
            'App\Events\DetalleVentaEvent@created_pedido_monto',
        ],  
        'pedido_monto.update' => [
            'App\Events\DetalleVentaEvent@update_pedido_monto',
        ], 

        // ------- Eventos (Triggers), para las acciones en el modelo PedidoAceptado --------
        'aceptadon_producto.created' => [
            'App\Events\PedidoAceptadoEvent@created_aceptadoproducto',
        ],         
        'llenar_inventario.created' => [
            'App\Events\PedidoAceptadoEvent@created_llenarinventario',
        ],
        'sumar_puntos.created' => [
            'App\Events\PedidoAceptadoEvent@created_sumarpuntos',
        ], 
        'regresion_stock.deleting' => [
            'App\Events\PedidoAceptadoEvent@deleting_regresionstock',
        ],              
        'regresion_puntos.deleting' => [
            'App\Events\PedidoAceptadoEvent@deleting_regresionpuntos',
        ],        

        // ------- Eventos (Triggers), para las acciones en el modelo PersonaNivel --------
        'verificar_nivel.created' => [
            'App\Events\PersonaNivelEvent@created_verificarnivel',
        ],              
        'verificar_nivel.update' => [
            'App\Events\PersonaNivelEvent@update_verificarnivel',
        ],        


    ];


    public function boot()
    {
        parent::boot();

        //
    }
}
