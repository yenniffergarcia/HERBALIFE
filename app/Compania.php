<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $table = 'compania';
	protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado'];  

}
