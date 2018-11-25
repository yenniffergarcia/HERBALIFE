<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Event;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
	protected $guarded = ['id'];
    protected $fillable = ['username', 'email', 'fkpersona', 'estado'];
    protected $hidden = ['password', 'remember_token'];   
    
    public function Persona()
    {
        return $this->belongsTo('App\Persona');
    }     
}
