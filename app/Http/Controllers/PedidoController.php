<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Factura;
use App\DetalleVenta;
use App\Persona;
use App\PedidoAceptado;
use App\PersonaNivel;
use Auth;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sistema.pedido.index');
    }

    public function getdata()
    {
        $persona = Persona::find(Auth::user()->fkpersona);

        $query = pedido::join('persona_nivel', 'pedido.fkpersonivel' ,'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel' ,'nivel.id')
            ->join('descuento', 'nivel.fkdescuento' ,'descuento.id')
            ->where('pedido.estado', 1)
            ->where('pedido.fkcodigo', $persona->codigo)
            ->select(['pedido.id as id', 'nivel.nombre as nivel', 'porcentaje', 'fecha', 
                    'subtotal', 'total', \DB::raw("(SELECT CONCAT(nombre1.' '.IFNULL(nombre2,'').' '.apellido1.' '.IFNULL(apellido2,'')) FROM persona p
                              WHERE p.id = '".$persona->id_padre."') as distribuidor"), 'pagado']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })              
            ->addColumn('action', function ($data) {
                $btn_cancelar = '';
                $btn_pagar = '';
                $detalle_venta = '<button class="venta-modal btn btn-success btn-xs" 
                type="button" data-id="'.$data->id.'">Agregar Productos</button>'; 
                $pedido_aceptado = '';

                $aceptados = PedidoAceptado::where('fkpedido', $data->id)->get();
                $solictados = DetalleVenta::where('fkpedido', $data->id)->get();
                
                if(count($aceptados) == count($solictados) && $data->pagado == 0)
                {
                    $btn_pagar = '<button class="pagar-modal btn btn-primary btn-xs" 
                    type="button" data-id="'.$data->id.'">Pagar</button>';

                    $btn_cancelar = '<button class="cancelar-modal btn btn-danger btn-xs" 
                    type="button" data-id="'.$data->id.'">Cancelar</button>';                  
                }
                if(count($aceptados) == count($solictados) && $data->pagado == 1)
                {
                    $detalle_venta = '<button class="detalle-modal btn btn-warning btn-xs" 
                    type="button" data-id="'.$data->id.'">Productos Solicitados</button>';

                    $pedido_aceptado = '<button class="aceptado-modal btn btn-warning btn-xs" 
                    type="button" data-id="'.$data->id.'">Productos Aceptados</button>';
                }

                return $detalle_venta.' '.$pedido_aceptado.' '.$btn_pagar.' '.$btn_cancelar;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function getpedido()
    {
        $query = pedido::join('persona', 'pedido.fkcodigo', 'persona.codigo')
            ->join('persona_nivel', 'pedido.fkpersonivel' ,'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel' ,'nivel.id')
            ->join('descuento', 'nivel.fkdescuento' ,'descuento.id')
            ->where('pedido.estado', 1)
            ->where('pedido.fkpersona', Auth::user()->fkpersona)
            ->select(['pedido.id as id', 'nivel.nombre as nivel', 'porcentaje', 'fecha', 
                    'subtotal', 'total', 'nombre1', 'nombre2', 'apellido1', 'apellido2', 'pagado']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            }) 
            ->addColumn('pagado', function ($data) {
                if($data->pagado == 1)
                    return 'Pagado';
                else
                    return 'No Pagado';
            })                           
            ->addColumn('action', function ($data) {
                $detalle_venta = ''; 
                $pedido_aceptado = '';

                $aceptados = PedidoAceptado::where('fkpedido', $data->id)->get();
                $solictados = DetalleVenta::where('fkpedido', $data->id)->get();
                
                if(count($aceptados) != count($solictados))
                {
                    $detalle_venta = '<button class="venta-modal btn btn-success btn-xs" 
                    type="button" data-id="'.$data->id.'">Productos del Pedido</button>';           
                }
                if(count($aceptados) == count($solictados) && $data->pagado == 1)
                {
                    $detalle_venta = '<button class="detalle-modal btn btn-warning btn-xs" 
                    type="button" data-id="'.$data->id.'">Productos Solicitados</button>';

                    $pedido_aceptado = '<button class="aceptado-modal btn btn-warning btn-xs" 
                    type="button" data-id="'.$data->id.'">Productos Aceptados</button>';
                }

                return $detalle_venta.' '.$pedido_aceptado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }    

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = pedido::find($id);
            return response()->json($data);
        }        
    }  

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $nivel = PersonaNivel::join('nivel', 'persona_nivel.fknivel' ,'nivel.id')
            ->join('descuento', 'nivel.fkdescuento' ,'descuento.id')
            ->where('persona_nivel.estado', 1)
            ->where('persona_nivel.persona', Auth::user()->fkpersona)
            ->select('persona_nivel.id as id')->first();

        $persona = Persona::find(Auth::user()->fkpersona);

        $data = new pedido;
        $data->fkcodigo = $persona->codigo;
        $data->fkpersona = $persona->id_padre;
        $data->fkpersonivel = $nivel->id;
        $data->fecha = date("Y-m-d");       
        $data->subtotal = 0.00;
        $data->total =  0.00;                
        $data->save();
        return response()->json($data);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = pedido::findOrFail($request->id);
            $data->estado = 0;
            if($data->save())
            {
                $productos = PedidoAceptado::where('fkpedido', $request->id)->select('id')->get();

                    foreach ($productos as $producto) 
                    {
                        $pedido = PedidoAceptado::findOrFail($producto->id);
                        $pedido->delete();
                    }
            }
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}
