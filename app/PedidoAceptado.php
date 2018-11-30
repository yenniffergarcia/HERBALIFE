<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoAceptado extends Model
{
    protected $table = 'pedido_aceptado';
	protected $guarded = ['id', 'fkstock', 'fkpedido'];
    protected $fillable = ['cantidad']; 
}
