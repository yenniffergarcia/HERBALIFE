<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoExpansion extends Model
{
    protected $table = 'equipo_expansion';
    protected $guarded = ['id']; 
    protected $fillable = ['nombre', 'porcentaje']; 
}
