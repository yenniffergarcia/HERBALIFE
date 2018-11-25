<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
	protected $guarded = ['id', 'fkpersona', 'fkcarga'];
    protected $fillable = ['cantidad'];  

    public function DetalleVenta()
    {
        return $this->hasOne('App\Detalle_Venta');
    }

    public function Persona()
    {
        return $this->belongsTo('App\Persona');
    }  
    
    public function Carga()
    {
        return $this->belongsTo('App\Carga');
    }     
}
