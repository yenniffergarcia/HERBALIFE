<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class PedidoAceptado extends Model
{
    protected $table = 'pedido_aceptado';
	protected $guarded = ['id', 'fkstock', 'fkpedido'];
    protected $fillable = ['cantidad']; 

    public static function boot() 
    {

	    parent::boot();

	    static::created(function($data) {
            Event::fire('aceptadon_producto.created', $data);
            Event::fire('llenar_inventario.created', $data);
            Event::fire('sumar_puntos.created', $data);
        });

        static::deleting(function($data) {
            Event::fire('regresion_stock.deleting', $data);
            Event::fire('regresion_puntos.deleting', $data);
        });        
               
	} 

}
