<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Event;

class User extends Authenticatable
{
    use Notifiable;

	protected $guarded = ['id', 'fkestado'];
    protected $fillable = ['username', 'email', 'fecha_inactivo', 'fkpersona'];
    protected $hidden = ['password', 'remember_token', 'token'];    

	public static function dataUsuario(){
		return User::join('persona', 'users.fkpersona', '=', 'persona.id')
					->join('estado', 'users.fkestado', '=', 'estado.id')
                    ->select(['users.id as id', 'users.username as username', 'users.email as email', 'users.fecha_inactivo as fecha_inactivo', 'persona.nombre1 as nombre1', 'persona.nombre2 as nombre2', 'persona.apellido1 as apellido1', 'persona.apellido2 as apellido2', 'users.fkestado as fkestado', 'estado.nombre as estado']);
	} 

    public static function buscarIDUsuario($id)
    {
        return User::where('fkpersona', $id)->first();       
    } 

    public static function existeUsuario($id)
    {
        return User::select('username')->where('fkpersona', $id)->get();       
    }  

    public static function boot() {

        parent::boot();

        static::created(function($data) {
            Event::fire('user.created', $data);
        });

        static::updated(function($data) {
            Event::fire('user.updated', $data);
        });

        static::updating(function($data) {
            Event::fire('user.updating', $data);
        });     

        static::deleted(function($data) {
            Event::fire('user.deleted', $data);
        });

    }          	   
}
