<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    protected $table = 'detalle_venta';
	protected $guarded = ['id', 'fkstock', 'fkfactura'];
    protected $fillable = ['cantidad ', 'fecha', 'estado']; 

    public function Stock()
    {
        return $this->belongsTo('App\Stock');
    } 
    
    public function Factura()
    {
        return $this->belongsTo('App\Factura');
    }       
}
