<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoAsociado extends Model
{
    protected $table = 'pago_asociado';
    protected $guarded = ['id', 'fkpersona', 'fkmes']; 
    protected $fillable = ['monto', 'anio']; 
}
