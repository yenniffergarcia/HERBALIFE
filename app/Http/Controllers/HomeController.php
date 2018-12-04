<?php

namespace App\Http\Controllers;

use PDF;
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
use App\PedidoAceptado;
use App\PersonaNivel;
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

    // ------------------- Funciones para las Gráficas  ------------------------- 

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
        $resultado = array();
       			       			
       	$puntos = Persona::where('id_padre', Auth::user()->fkpersona)->where('estado', 1)
       		->select('nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id = ".'persona.id'." AND YEAR(pm.fecha) = ".date('Y').") as red"))->get();

       	foreach ($puntos as $punto) 
       	{
            $numero = (int) $punto->red;
	        $dataCol['name'] = $punto->nombre1.' '.$punto->apellido1;
	        $dataCol['y'] = $numero;
            array_push($resultado,$dataCol);                     		
       	}
        return response()->json($resultado); 
    }   

    // ------------------- Funciones para la Reporteria de Pedido  -------------------------

    public function reporteriaVerPedido() 
    {
        $stocks = Stock::join('producto', 'stock.fkproducto', 'producto.id')
                ->where('stock.fkpersona', Auth::user()->fkpersona)
                ->select('stock.id as id', 'nombre')->get();

        $niveles = PersonaNivel::join('nivel', 'persona_nivel.fknivel', 'nivel.id')
                ->where('persona_nivel.fkpersona', Auth::user()->fkpersona)
                ->select('persona_nivel.id as id', 'nombre')->get();

        $persona = Persona::find(Auth::user()->fkpersona);

        $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
            ->where('pedido.fkcodigo', $persona->codigo)
            ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

        $pedidos = Factura::where('fkcodigo', $persona->codigo)
            ->where('estado', 1)
            ->select('id', 'subtotal', 'total', 'fecha')->get();

        return view('reporteria.pedido.mostrar-reporte', compact('productos', 'pedidos', 'stocks', 'niveles'));                   
    }

    public function reporteriaFiltrarPedido(Request $request) 
    {
        $stocks = Stock::join('producto', 'stock.fkproducto', 'producto.id')
                ->where('stock.fkpersona', Auth::user()->fkpersona)
                ->select('stock.id as id', 'nombre')->get();

        $niveles = PersonaNivel::join('nivel', 'persona_nivel.fknivel', 'nivel.id')
                ->where('persona_nivel.fkpersona', Auth::user()->fkpersona)
                ->select('persona_nivel.id as id', 'nombre')->get();

        $persona = Persona::find(Auth::user()->fkpersona);

        if(intval($request->fkproducto) > 0 && intval($request->fkpersonivel) == 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('producto.id', $request->fkproducto)
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();

        }
        if(intval($request->fkproducto) == 0 && intval($request->fkpersonivel) > 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkpersonivel', $request->fkpersonivel)
                ->where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();
        }
        if(intval($request->fkproducto) > 0 && intval($request->fkpersonivel) > 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('producto.id', $request->fkproducto)
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkpersonivel', $request->fkpersonivel)
                ->where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();
        } 
        if(intval($request->fkproducto) == 0 && intval($request->fkpersonivel) == 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();

        }     

        return view('reporteria.pedido.mostrar-reporte', compact('productos', 'pedidos', 'stocks', 'niveles'));                   
    } 

    public function imprimirReportePedido($fkproducto, $fkpersonivel)
    {
        $persona = Persona::find(Auth::user()->fkpersona);

        if(intval($fkproducto) > 0 && intval($fkpersonivel) == 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('producto.id', $fkproducto)
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();

        }
        if(intval($fkproducto) == 0 && intval($fkpersonivel) > 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkpersonivel', $fkpersonivel)
                ->where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();
        }
        if(intval($fkproducto) > 0 && intval($fkpersonivel) > 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('producto.id', $fkproducto)
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkpersonivel', $fkpersonivel)
                ->where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();
        } 
        if(intval($fkproducto) == 0 && intval($fkpersonivel) == 0)
        {
            $productos = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
                ->join('producto', 'stock.fkproducto', 'producto.id')
                ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
                ->where('pedido.fkcodigo', $persona->codigo)
                ->select('pedido_aceptado.cantidad as cantidad', 'producto.nombre as producto', 'producto.punto as punto', 'pedido_aceptado.fkpedido as fkpedido')->get();

            $pedidos = Factura::where('fkcodigo', $persona->codigo)
                ->where('estado', 1)
                ->select('id', 'subtotal', 'total', 'fecha')->get();

        }     

        $pdf = PDF::loadView('reporteria.pedido.imprimir-reporte', compact('productos', 'pedidos'));

        return $pdf->download('reporte_pedido_'. date('d-m-Y h:i:s') .'.pdf');
    }


    public function reporteriaVerInformeAsociado() 
    {
        $bonificaciones = Bonificacion::join('mes', 'bonificacion.fkmes', 'mes.id')
                ->join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
                ->where('bonificacion.fkpersona', Auth::user()->fkpersona)
                ->select('nombre', 'porcentaje', 'monto', 'mes', 'anio')->get();

        $regalias = Regalia::join('mes', 'regalia.fkmes', 'mes.id')
                ->join('pedido', 'regalia.fkpedido', 'pedido.id')
                ->where('regalia.fkpersona', Auth::user()->fkpersona)
                ->select('pedido.id as id', 'porcentaje', 'monto', 'mes', 'anio')->get();

        $puntos = PuntoMes::join('mes', 'punto_mes.fkmes', 'mes.id')
                ->where('punto_mes.fkpersona', Auth::user()->fkpersona)
                ->select('punto', 'mes', 'fecha')->get();   

        $puntos_red = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
            ->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'.") as red"))->get();                             

        return view('reporteria.informe.mostrar-reporte', compact('bonificaciones', 'regalias', 'puntos', 'puntos_red'));                   
    }

    public function reporteriaFiltrarInformeAsociado(Request $request) 
    {
        if(intval($request->anio) > 0)
        {
            $bonificaciones = Bonificacion::join('mes', 'bonificacion.fkmes', 'mes.id')
                    ->join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
                    ->where('bonificacion.fkpersona', Auth::user()->fkpersona)
                    ->where('bonificacion.anio', $request->anio)
                    ->select('nombre', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $regalias = Regalia::join('mes', 'regalia.fkmes', 'mes.id')
                    ->join('pedido', 'regalia.fkpedido', 'pedido.id')
                    ->where('regalia.fkpersona', Auth::user()->fkpersona)
                    ->where('regalia.anio', $request->anio)
                    ->select('pedido.id as id', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $puntos = PuntoMes::join('mes', 'punto_mes.fkmes', 'mes.id')
                    ->where('punto_mes.fkpersona', Auth::user()->fkpersona)
                    ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), $request->anio)
                    ->select('punto', 'mes', 'fecha')->get();   

            $puntos_red = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
                ->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'." AND YEAR(pm.fecha) = ".$request->anio.") as red"))->get();  
        }
        else
        {
            $bonificaciones = Bonificacion::join('mes', 'bonificacion.fkmes', 'mes.id')
                    ->join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
                    ->where('bonificacion.fkpersona', Auth::user()->fkpersona)
                    ->select('nombre', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $regalias = Regalia::join('mes', 'regalia.fkmes', 'mes.id')
                    ->join('pedido', 'regalia.fkpedido', 'pedido.id')
                    ->where('regalia.fkpersona', Auth::user()->fkpersona)
                    ->select('pedido.id as id', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $puntos = PuntoMes::join('mes', 'punto_mes.fkmes', 'mes.id')
                    ->where('punto_mes.fkpersona', Auth::user()->fkpersona)
                    ->select('punto', 'mes', 'fecha')->get();   

            $puntos_red = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
                ->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'.") as red"))->get();
        }

        return view('reporteria.informe.mostrar-reporte', compact('bonificaciones', 'regalias', 'puntos', 'puntos_red'));                   
    }

    public function imprimirReporteInformeAsociado($anio)
    {
        if(intval($anio) > 0)
        {
            $bonificaciones = Bonificacion::join('mes', 'bonificacion.fkmes', 'mes.id')
                    ->join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
                    ->where('bonificacion.fkpersona', Auth::user()->fkpersona)
                    ->where('bonificacion.anio', $anio)
                    ->select('nombre', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $regalias = Regalia::join('mes', 'regalia.fkmes', 'mes.id')
                    ->join('pedido', 'regalia.fkpedido', 'pedido.id')
                    ->where('regalia.fkpersona', Auth::user()->fkpersona)
                    ->where('regalia.anio', $anio)
                    ->select('pedido.id as id', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $puntos = PuntoMes::join('mes', 'punto_mes.fkmes', 'mes.id')
                    ->where('punto_mes.fkpersona', Auth::user()->fkpersona)
                    ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), $anio)
                    ->select('punto', 'mes', 'fecha')->get();   

            $puntos_red = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
                ->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'." AND YEAR(pm.fecha) = ".$request->anio.") as red"))->get();  
        }
        else
        {
            $bonificaciones = Bonificacion::join('mes', 'bonificacion.fkmes', 'mes.id')
                    ->join('equipo_expansion', 'bonificacion.fkequipo_expansion', 'equipo_expansion.id')
                    ->where('bonificacion.fkpersona', Auth::user()->fkpersona)
                    ->select('nombre', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $regalias = Regalia::join('mes', 'regalia.fkmes', 'mes.id')
                    ->join('pedido', 'regalia.fkpedido', 'pedido.id')
                    ->where('regalia.fkpersona', Auth::user()->fkpersona)
                    ->select('pedido.id as id', 'porcentaje', 'monto', 'mes', 'anio')->get();

            $puntos = PuntoMes::join('mes', 'punto_mes.fkmes', 'mes.id')
                    ->where('punto_mes.fkpersona', Auth::user()->fkpersona)
                    ->select('punto', 'mes', 'fecha')->get();   

            $puntos_red = Persona::where('id', Auth::user()->fkpersona)->where('estado', 1)
                ->select('codigo', 'nombre1', 'apellido1', \DB::raw("(SELECT SUM(pm.punto) FROM punto_mes pm INNER JOIN persona p ON p.id = pm.fkpersona WHERE p.id_padre = ".'persona.id'.") as red"))->get();
        }

        $pdf = PDF::loadView('reporteria.informe.imprimir-reporte', compact('bonificaciones', 'regalias', 'puntos', 'puntos_red'));

        return $pdf->download('reporte_informe_'. date('d-m-Y h:i:s') .'.pdf');
    }    

}
