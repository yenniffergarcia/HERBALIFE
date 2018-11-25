<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuento';
	protected $guarded = ['id'];
    protected $fillable = ['porcentaje'];  

    public function Nivel()
    {
        return $this->hasOne('App\Nivel');
    }       
}
