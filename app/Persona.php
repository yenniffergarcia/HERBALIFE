<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class Persona extends Model
{
    protected $table = 'persona';
	protected $guarded = ['id', 'codigo', 'fkdepartamento'];
    protected $fillable = ['nombre1', 'nombre2', 'apellido1', 'apellido2', 'apellido3', 
    'direccion', 'id_padre', 'email', 'estado'];

    public function PuntoMes()
    {
        return $this->hasOne('App\Punto_Mes');
    }   

    public function User()
    {
        return $this->hasOne('App\User');
    } 

    public function Telefono()
    {
        return $this->hasOne('App\Telefono');
    }    

    public function PersonaNivel()
    {
        return $this->hasOne('App\Persona_Nivel');
    }  
    
    public function Departamento()
    {
        return $this->belongsTo('App\Departamento');
    } 
    
    public function FacturaCodigo()
    {
        return $this->hasOne('App\Factura', 'codigo');
    }    
    
    public function FacturaPersona()
    {
        return $this->hasOne('App\Factura', 'fkpersona');
    }    
    
    public static function boot() {

	    parent::boot();

	    static::created(function($persona) {
	        Event::fire('persona.created', $persona);
	    });
	}    
}
