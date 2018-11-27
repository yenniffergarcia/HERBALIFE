<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class Stock extends Model
{
    protected $table = 'stock';
	protected $guarded = ['id', 'fkpersona', 'fkproducto'];
    protected $fillable = ['cantidad', 'fecha_vencimiento'];  

    public static function boot() {

	    parent::boot();

	    static::created(function($data) {
            Event::fire('stock.created', $data);
        });
        
	    static::updated(function($data) {
            Event::fire('stock.updated', $data);
	    });        
	}     
}
