<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
	protected $guarded = ['id', 'fkcategoria'];
    protected $fillable = ['nombre', 'descripcion', 'punto', 'precio', 'estado'];  

    public function PaqueteProducto()
    {
        return $this->hasOne('App\Paquete_Producto');
    }   
    
    public function Categoria()
    {
        return $this->belongsTo('App\Categoria');
    }    
}
