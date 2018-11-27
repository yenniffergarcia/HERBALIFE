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
    
    public static function boot() {

	    parent::boot();

	    static::created(function($persona) {
	        Event::fire('persona.created', $persona);
	    });
	}    
}
