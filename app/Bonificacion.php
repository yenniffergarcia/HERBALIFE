<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonificacion extends Model
{
    protected $table = 'bonificacion';
    protected $guarded = ['id', 'fkmes', 'fkpersona', 'fkequipo_expansion']; 
    protected $fillable = ['monto', 'anio']; 
}
