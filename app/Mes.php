<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $table = 'mes';
	protected $guarded = ['id'];
    protected $fillable = ['mes'];  

    public function PuntoMes()
    {
        return $this->hasOne('App\Punto_Mes');
    }    
}
