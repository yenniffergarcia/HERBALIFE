<?php

namespace App\Http\Controllers;

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
use App\Stock;
use Auth;

class DetalleVentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('gerente');
        $this->middleware('asociado_interno');
        $this->middleware('asociado_externo');
    }

    protected $verificar_insert =
    [
        'fkstock' => 'required|integer',
        'fkpedido' => 'required|integer', 
        'cantidad' => 'required|integer',                                 
    ];

    public function index()
    {
        //
    }

    public function getdata($fkpedido)
    {
        $query = detalleventa::join('stock', 'detalle_venta.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->where('detalle_venta.fkpedido', $fkpedido)
            ->where('detalle_venta.estado', 1)
            ->select(['detalle_venta.id as id', 'detalle_venta.created_at as fecha', 'detalle_venta.cantidad as cantidad', 'nombre', 'punto', 'precio', 'fkpedido', 'fkstock']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })             
            ->addColumn('total_precio', function ($data) {
                return $data->cantidad * $data->precio;
            })
            ->addColumn('total_punto', function ($data) {
                return $data->cantidad * $data->punto;
            })                   
            ->addColumn('action', function ($data) {
                $btn_cancelar = '';

                $aceptado = PedidoAceptado::where('fkpedido', $data->fkpedido)
                           ->where('fkstock', $data->fkstock)->first();
                
                if(is_null($aceptado))
                {
                    $btn_cancelar = '<button class="eliminar-modal btn btn-danger btn-xs" 
                    type="button" data-id="'.$data->id.'">Eliminar</button>';                       
                }

                return $btn_cancelar;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function getpedido($fkpedido)
    {
        $query = detalleventa::join('stock', 'detalle_venta.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->where('detalle_venta.fkpedido', $fkpedido)
            ->where('detalle_venta.estado', 1)
            ->select(['detalle_venta.id as id', 'detalle_venta.created_at as fecha', 'detalle_venta.cantidad as cantidad', 'nombre', 'punto', 'precio', 'fkpedido', 'fkstock']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })             
            ->addColumn('total_precio', function ($data) {
                return $data->cantidad * $data->precio;
            })
            ->addColumn('total_punto', function ($data) {
                return $data->cantidad * $data->punto;
            })                   
            ->addColumn('action', function ($data) {
                $btn_aceptar = '';
                $btn_rechazar = '';

                $aceptado = PedidoAceptado::where('fkpedido', $data->fkpedido)
                           ->where('fkstock', $data->fkstock)->first();
                
                if(is_null($aceptado))
                {
                    $btn_aceptar = '<button class="si-modal btn btn-primary btn-xs" 
                    type="button" data-cantidad="'.$data->cantidad.'" data-fkstock="'.$data->fkstock.'" data-fkpedido="'.$data->fkpedido.'">Aprobar</button>';    

                    $btn_rechazar = '<button class="no-modal btn btn-warning btn-xs" 
                    type="button" data-id="'.$data->id.'">Rechazar</button>';       
                }

                return $btn_aceptar.' '.$btn_rechazar;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }   

    public function getaceptado($fkpedido)
    {
        $query = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->where('pedido_aceptado.fkpedido', $fkpedido)
            ->select(['pedido_aceptado.created_at as fecha', 'cantidad', 'nombre', 'punto', 'precio']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })             
            ->addColumn('total_precio', function ($data) {
                return $data->cantidad * $data->precio;
            })
            ->addColumn('total_punto', function ($data) {
                return $data->cantidad * $data->punto;
            })                   
            ->make(true);
    }      

    public function dropStock(Request $request, $categoria)
    {
        if($request->ajax()){

            $persona = Persona::find(Auth::user()->fkpersona);

            $data = stock::join('producto', 'stock.fkproducto', 'producto.id')
                    ->join('categoria', 'producto.fkcategoria', 'categoria.id')
                    ->where('producto.fkcategoria', $categoria)
                    ->where('stock.fkpersona', $persona->id_padre)
                    ->where('stock.cantidad', '>', '0')
                    ->select('stock.*', 'categoria.nombre as categoria', 'producto.nombre as producto')->get();
            return response()->json($data);
        }        
    }

    public function dropVerficiarStock(Request $request, $stock, $cantidad)
    {
        if($request->ajax()){
            $verficar = Stock::find($stock);
            if(($verficar->cantidad - $cantidad) < 0)
            {
                $data = 0;
            }
            else
            {
                $data = 1;
            }
            return response()->json($data);
        }        
    }   

    public function verificarProductoDetalle(Request $request, $stock, $pedido)
    {
        if($request->ajax()){
            $verificar = detalleventa::where('fkstock', $stock)
                ->where('fkpedido', $pedido)->first();
            if(!is_null($verificar))
            {
                $data = 0;
            }
            else
            {
                $data = 1;
            }
            return response()->json($data);
        }        
    }      

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->verificar_insert);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = new detalleventa;
            $data->fkstock = $request->fkstock;
            $data->fkpedido = $request->fkpedido;
            $data->cantidad = $request->cantidad;         
            $data->save();
            return response()->json($data);
        } 
    }

    public function storeAprobado(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->verificar_insert);
        
        $estado = detalleventa::where('fkstock', $request->fkstock)
                    ->where('fkpedido', $request->fkpedido)
                    ->where('estado', 1)->get();

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = new PedidoAceptado;
            $data->fkstock = $request->fkstock;
            $data->fkpedido = $request->fkpedido;
            $data->cantidad = $request->cantidad;
            if(count($estado) > 0)
            {
                $data->save();
            }         
            return response()->json($data);
        } 
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
        //
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = detalleventa::findOrFail($request->id);
            $data->estado = 0;
            $data->save();
            return response()->json($data);
        }        
    }

    public function destroy($id)
    {
        //
    }
}
