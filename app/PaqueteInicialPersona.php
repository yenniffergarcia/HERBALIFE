<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class PaqueteInicialPersona extends Model
{
    protected $table = 'paquete_inicial_persona';
	protected $guarded = ['id', 'fkpersona', 'fkpaquete_producto'];
    protected $fillable = ['estado'];

    public static function boot() {

	    parent::boot();

	    static::created(function($data) {
            Event::fire('paque_puntos.created', $data);
            Event::fire('paquete_nivel.created', $data);
        });
               
	}    
}
