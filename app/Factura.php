<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
	protected $guarded = ['id', 'fkcodigo', 'fkpersona', 'fkpersonivel'];
    protected $fillable = ['fecha', 'subtotal', 'total']; 

    public function PuntoMes()
    {
        return $this->hasOne('App\Punto_Mes');
    }   
        
    public function PersonaCodigo()
    {
        return $this->belongsTo('App\Persona', 'fkcodigo');
    }   
    
    public function Persona()
    {
        return $this->belongsTo('App\Persona', 'fkpersona');
    }     
}
