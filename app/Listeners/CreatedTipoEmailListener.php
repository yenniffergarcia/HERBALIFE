<?php

namespace App\Listeners;

use App\Events\CreatedTipoEmailEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Bitacora;
use Auth;

class CreatedTipoEmailListener
{
    public function __construct()
    {
        //
    }

    public function handle(CreatedTipoEmailEvent $event)
    {
        \Log::info('created', ['insert' => $event->tipo_email]);

        $insert = new Bitacora();
        $insert->tabla = 'tipo_email';
        $insert->accion = 'create';
        $insert->descripcion = 'fue creado';
        $insert->idtabla = $event->tipo_email->id;
        $insert->fkuser = Auth::user()->id;
        $insert->save();

        return $this;
    }
}
