<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
	protected $guarded = ['id', 'fkstock', 'fkpedido'];
    protected $fillable = ['cantidad', 'estado']; 
      
}
