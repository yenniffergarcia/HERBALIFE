<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regalia extends Model
{
    protected $table = 'regalia';
    protected $guarded = ['id', 'fkpersona', 'fkcodigo', 'fkmes', 'fkpedido']; 
    protected $fillable = ['monto', 'porcentaje', 'anio']; 
}
