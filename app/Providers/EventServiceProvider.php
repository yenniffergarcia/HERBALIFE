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

    ];


    public function boot()
    {
        parent::boot();

        //
    }
}
