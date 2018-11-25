<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Carga extends Model
{
    protected $table = 'detalle_carga';
	protected $guarded = ['id', 'fkpersona', 'fkproducto'];
    protected $fillable = ['cantidad ', 'fecha_vencimiento', 'estado'];  

    public function Persona()
    {
        return $this->belongsTo('App\Persona');
    } 
    
    public function Producto()
    {
        return $this->belongsTo('App\Producto');
    }        
}
