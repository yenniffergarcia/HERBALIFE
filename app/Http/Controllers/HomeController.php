<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Stock;
use App\Bonifciacion;
use App\Regalia;
use App\Persona;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    public function index()
    {
    	$pedidos = Factura::join('persona', 'pedido.fkpersona', 'persona.id')
    		->join('persona_nivel', 'pedido.fkpersonivel', 'persona_nivel.id')
    		->join('nivel', 'persona_nivel.fknivel', 'nivel.id')
    		->where('pedido.fkpersona', Auth::user()->fkpersona)->where('pedido.estado', 1)
    		->select('pedido.*', 'nombre1', 'apellido1', 'codigo', 'nivel.nombre as nivel')->take(20)->get();

    	$stocks = Stock::join('producto', 'stock.fkproducto', 'producto.id')
    		->where('stock.fkpersona', Auth::user()->fkpersona)
    		->select('stock.*', 'nombre', 'punto', 'precio')->take(20)->get();

    	$redes = Persona::where('id_padre', Auth::user()->fkpersona)
    		->select('codigo', \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND p.fkmes = ".date('n')." AND YEAR(p.fecha) = ".date('Y').") as punteo_mes"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 2 ) as punteo_dos_meses"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 12 ) as punteo_doce_meses"))->get();

    	$puntos = Persona::where('id', Auth::user()->fkpersona)
    		->select(\DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND p.fkmes = ".date('n')." AND YEAR(p.fecha) = ".date('Y').") as punteo_mes"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 2 ) as punteo_dos_meses"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 12 ) as punteo_doce_meses"))->get();

    	$informacion_pagos = Persona::where('id', Auth::user()->fkpersona)
    		->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(b.monto) FROM bonificacion b WHERE b.fkpersona = ".'persona.id'." AND b.anio = ".date('Y').") as bonificacion"), \DB::raw("(SELECT SUM(r.monto) FROM regalia r WHERE r.fkpersona = ".'persona.id'." AND r.anio = ".date('Y').") as regalia"), \DB::raw("(SELECT SUM(p.total-p.subtotal) FROM pedido p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y').") as descuento"), \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'." AND YEAR(pm.fecha) = ".date('Y').") as red"))->get();

        return view('home', compact('pedidos', 'stocks', 'redes', 'puntos', 'informacion_pagos'));
    }
}
