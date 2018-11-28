<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Event;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
	protected $guarded = ['id', 'fkpersona', 'fkrol'];
    protected $fillable = ['username', 'email', 'estado'];
    protected $hidden = ['password', 'remember_token'];   
   
}
