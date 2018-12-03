<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Factura;
use App\Stock;
use App\Bonificacion;
use App\Regalia;
use App\Persona;
use App\PuntoMes;
use App\PagoAsociado;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['indexPago', 'indexRegalia', 'indexBonificacion']]);
        $this->middleware('gerente', ['only' => ['indexPago', 'indexRegalia', 'indexBonificacion']]);
        //$this->middleware('asociado_interno');
        //$this->middleware('asociado_externo');
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

    	$redes = Persona::where('id_padre', Auth::user()->fkpersona)->where('estado', 1)
    		->select('codigo', \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND p.fkmes = ".date('n')." AND YEAR(p.fecha) = ".date('Y').") as punteo_mes"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 2 ) as punteo_dos_meses"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 12 ) as punteo_doce_meses"))->get();

    	$puntos = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
    		->select(\DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND p.fkmes = ".date('n')." AND YEAR(p.fecha) = ".date('Y').") as punteo_mes"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 2 ) as punteo_dos_meses"), \DB::raw("(SELECT p.punto FROM punto_mes p WHERE p.fkpersona = ".'persona.id'." AND YEAR(p.fecha) = ".date('Y')." ORDER BY p.id DESC LIMIT 12 ) as punteo_doce_meses"))->get();

    	$informacion_pagos = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
    		->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(b.monto) FROM bonificacion b WHERE b.fkpersona = ".'persona.id'." AND b.anio = ".date('Y').") as bonificacion"), \DB::raw("(SELECT SUM(r.monto) FROM regalia r WHERE r.fkpersona = ".'persona.id'." AND r.anio = ".date('Y').") as regalia"), \DB::raw("(SELECT SUM(p.total-p.subtotal) FROM pedido p WHERE p.fkcodigo = ".'persona.codigo'." AND YEAR(p.fecha) = ".date('Y').") as descuento"), \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'." AND YEAR(pm.fecha) = ".date('Y').") as red"))->get();

        $regalias = Regalia::where('fkpersona', Auth::user()->fkpersona)->get();

        $boficaciones = Bonificacion::join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
            ->where('fkpersona', Auth::user()->fkpersona)
            ->select('porcentaje')->orderBy('bonificacion.id', 'DESC')->take(1)->get();

        $pagos = PagoAsociado::where('fkpersona', Auth::user()->fkpersona)->get();

        return view('home', compact('pedidos', 'stocks', 'redes', 'puntos', 'informacion_pagos', 'regalias', 'pagos', 'boficaciones'));
    }

    public function indexPuntos()
    {
        return view('sistema.punto.index');
    }

    public function indexPago()
    {
        return view('sistema.pago.index');
    }

    public function indexRegalia()
    {
        return view('sistema.regalia.index');
    }

    public function indexBonificacion()
    {
        return view('sistema.bonificacion.index');
    }

    public function getdataPuntos()
    {
        $query = PuntoMes::join('mes', 'punto_mes.fkmes' ,'mes.id')->select(['punto', 'mes', 'fecha']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })->make(true);
    }

    public function getdataPago()
    {
        $query = PagoAsociado::join('mes', 'pago_asociado.fkmes' ,'mes.id')->select(['monto', 'mes', 'anio']);

        return Datatables::of($query)->make(true);
    }

    public function getdataRegalia()
    {
        $query = Regalia::join('mes', 'regalia.fkmes' ,'mes.id')
            ->select(['monto', 'mes', 'porcentaje', 'anio', 'fkcodigo', 'fkpedido']);

        return Datatables::of($query)->make(true);
    }

    public function getdataBonificacion()
    {
        $query = Bonificacion::join('mes', 'bonificacion.fkmes' ,'mes.id')
            ->join('equipo_expansion', 'bonificacion.fkequipo_expansion' ,'equipo_expansion.id')
            ->select(['monto', 'mes', 'anio', 'nombre', 'porcentaje']);

        return Datatables::of($query)->make(true);
    }    

    public function mostrarGraficaNivel()
    {
        $dataCol1 = array();
        $dataCol2 = array();
        $dataCol3 = array();
        $dataCol4 = array();
        $resultado = array();

        $nivel1 = Persona::join('persona_nivel', 'persona.id', 'persona_nivel.fkpersona')
        			->where('persona.id_padre', Auth::user()->fkpersona)
        			->where('persona_nivel.fknivel', 1)
        			->where('persona_nivel.estado', 1)
        			->where('persona.estado', 1)->get();

        $nivel2 = Persona::join('persona_nivel', 'persona.id', 'persona_nivel.fkpersona')
        			->where('persona.id_padre', Auth::user()->fkpersona)
        			->where('persona_nivel.fknivel', 2)
        			->where('persona_nivel.estado', 1)
        			->where('persona.estado', 1)->get(); 

        $nivel3 = Persona::join('persona_nivel', 'persona.id', 'persona_nivel.fkpersona')
        			->where('persona.id_padre', Auth::user()->fkpersona)
        			->where('persona_nivel.fknivel', 3)
        			->where('persona_nivel.estado', 1)
        			->where('persona.estado', 1)->get();

        $nivel4 = Persona::join('persona_nivel', 'persona.id', 'persona_nivel.fkpersona')
        			->where('persona.id_padre', Auth::user()->fkpersona)
        			->where('persona_nivel.fknivel', 4)
        			->where('persona_nivel.estado', 1)
        			->where('persona.estado', 1)->get();         			       			

        $dataCol1['name'] = 'Asociado Independiente';
        $dataCol1['y'] = count($nivel1);       
        $dataCol2['name'] = 'Consultor Mayor'; 
        $dataCol2['y'] = count($nivel2);
        $dataCol3['name'] = 'Constructor del Exito';
        $dataCol3['y'] = count($nivel3);       
        $dataCol4['name'] = 'Mayorista'; 
        $dataCol4['y'] = count($nivel4);        

        array_push($resultado,$dataCol1);
        array_push($resultado,$dataCol2);
        array_push($resultado,$dataCol3);
        array_push($resultado,$dataCol4);
        return response()->json($resultado); 
    }

    public function mostrarGraficaPunteoAsociado()
    {
        $dataCol = array();
       			       			
       	$puntos = Persona::where('id_padre', Auth::user()->fkpersona)->where('estado', 1)
       		->select('nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'." AND YEAR(pm.fecha) = ".date('Y').") as red"))->get();

       	foreach ($puntos as $punto) 
       	{
	        $dataCol['name'] = $punto->nombre1.' '.$punto->apellido1;
	        $dataCol['y'] = intval($punto->red);                     		
       	}
        return response()->json($dataCol); 
    }    

}
