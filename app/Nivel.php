<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'nivel';
	protected $guarded = ['id', 'fkdescuento'];
    protected $fillable = ['nombre', 'estado'];  

}
