<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete_Producto extends Model
{
    protected $table = 'paquete_producto';
	protected $guarded = ['id', 'fkproducto', 'fkpaquete'];
    protected $fillable = ['estado'];

    public function PaqueteInicial()
    {
        return $this->belongsTo('App\Paquete_Inicial');
    }     

    public function Producto()
    {
        return $this->belongsTo('App\Producto');
    }        
}
