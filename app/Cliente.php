<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $guarded = ['id']; 
    protected $fillable = ['nombre', 'apellido', 'telefono', 'direccion', 'estado'];  
}
