<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class DetalleCarga extends Model
{
    protected $table = 'detalle_carga';
	protected $guarded = ['id', 'fkpersona', 'fkproducto'];
    protected $fillable = ['cantidad ', 'fecha_vencimiento', 'estado'];  

    public static function boot() {

	    parent::boot();

	    static::created(function($data) {
            Event::fire('stock_carga.created', $data);
        });
        
	    static::updated(function($data) {
            Event::fire('stock_carga.updated', $data);
	    });        
	}     
}
