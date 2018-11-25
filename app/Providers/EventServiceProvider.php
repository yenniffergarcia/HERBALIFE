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
        'persona.created' => [
            'App\Events\PersonaEvent@created',
        ],                                       
    ];


    public function boot()
    {
        parent::boot();

        //
    }
}
