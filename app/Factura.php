<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'pedido';
	protected $guarded = ['id', 'fkcodigo', 'fkpersona', 'fkpersonivel'];
    protected $fillable = ['fecha', 'subtotal', 'total', 'estado', 'pagado']; 
    
}
