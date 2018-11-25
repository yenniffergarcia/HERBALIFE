<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaNivel extends Model
{
    protected $table = 'persona_nivel';
	protected $guarded = ['id', 'fkpersona', 'fknivel'];
    protected $fillable = ['estado'];

    public function Nivel()
    {
        return $this->belongsTo('App\Nivel');
    }     

    public function Persona()
    {
        return $this->belongsTo('App\Persona');
    }     
}
