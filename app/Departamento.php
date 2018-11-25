<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';
	protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado'];  

    public function Persona()
    {
        return $this->hasOne('App\Persona');
    }    
}
