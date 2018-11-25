<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteInicial extends Model
{
    protected $table = 'paquete_inicial';
	protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado'];

    public function PaqueteProducto()
    {
        return $this->hasOne('App\Paquete_Producto');
    }     
}
