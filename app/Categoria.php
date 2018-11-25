<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class Categoria extends Model
{
    protected $table = 'categoria';
	protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado'];      
}
