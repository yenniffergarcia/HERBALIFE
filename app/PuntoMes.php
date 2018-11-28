<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuntoMes extends Model
{
    protected $table = 'punto_mes';
    protected $guarded = ['id', 'fkmes', 'fkpersona', 'fecha']; 
    protected $fillable = ['fecha', 'punto'];  

}
