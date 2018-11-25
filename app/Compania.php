<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class Compania extends Model
{
    protected $table = 'compania';
	protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado'];  

    public function Telefono()
    {
        return $this->hasOne('App\Telefono');
    }  
}
