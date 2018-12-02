<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
	protected $guarded = ['id', 'fkstock', 'fkpedido'];
    protected $fillable = ['cantidad', 'estado']; 

    public static function boot() {

	    parent::boot();

	    static::created(function($data) {
            Event::fire('pedido_monto.created', $data);
        });
           
	    static::updated(function($data) {
            Event::fire('pedido_monto.update', $data);
        });               
	}     
      
}
