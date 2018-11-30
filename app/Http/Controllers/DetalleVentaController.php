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

class DetalleVentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            ->select(['detalle_venta.id as id', 'detalle_venta.created_at as fecha', 'cantidad', 'nombre', 'punto', 'precio', 'fkpedido', 'fkstock']);

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
            ->select(['detalle_venta.id as id', 'detalle_venta.created_at as fecha', 'cantidad', 'nombre', 'punto', 'precio', 'fkpedido', 'fkstock']);

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
                    type="button" data-id="'.$data->id.'">Aprobar</button>';    

                    $btn_rechazar = '<button class="si-modal btn btn-warning btn-xs" 
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
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = new PedidoAceptado;
            $data->fkstock = $request->fkstock;
            $data->fkpedido = $request->fkpedido;
            $data->cantidad = $request->cantidad;         
            $data->save();
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
