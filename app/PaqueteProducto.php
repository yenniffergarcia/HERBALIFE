<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteProducto extends Model
{
    protected $table = 'paquete_producto';
	protected $guarded = ['id', 'fkproducto', 'fkpaquete'];
    protected $fillable = ['estado'];
       
}
