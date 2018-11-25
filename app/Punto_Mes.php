<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Punto_Mes extends Model
{
    protected $table = 'punto_mes';
    protected $guarded = ['id', 'fkmes', 'fkpersona', 'fkfactura']; 
    
    public function Mes()
    {
        return $this->belongsTo('App\Mes');
    }    

    public function Persona()
    {
        return $this->belongsTo('App\Persona');
    }    
    
    public function Factura()
    {
        return $this->belongsTo('App\Factura');
    }        
}
