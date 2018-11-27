<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
	protected $guarded = ['id', 'fkcategoria'];
    protected $fillable = ['nombre', 'descripcion', 'punto', 'precio', 'estado'];  
 
}
