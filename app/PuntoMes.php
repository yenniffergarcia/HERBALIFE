<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class PuntoMes extends Model
{
    protected $table = 'punto_mes';
    protected $guarded = ['id', 'fkmes', 'fkpersona']; 
    protected $fillable = ['fecha', 'punto'];  

    public static function boot() {

	    parent::boot();

	    static::creating(function($data) {
            Event::fire('verificar_nivel.created', $data);
            Event::fire('bonificacion_red.created', $data);
        });

        static::updating(function($data) {
            Event::fire('verificar_nivel.update', $data);
            Event::fire('bonificacion_red.update', $data);
        });     
               
	} 

}
