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
use App\User;
use App\PedidoAceptado;
use App\PersonaNivel;
use Auth;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('gerente');
        $this->middleware('asociado_interno', ['only' => ['index']]);
        //$this->middleware('asociado_externo');
    }

    public function index()
    {
        $button = '';

        $persona_session = Persona::find(Auth::user()->fkpersona);

        $rol_padre = User::where('fkpersona', $persona_session->id_padre)->first();

        if($rol_padre->fkrol == 3)
        {
            $button = '<button class="add-modal btn btn-primary btn-xs" 
            type="button">Generar Pedido</button>';            
        }
        return view('sistema.pedido.index', compact('button'));
    }

    public function indexRecibidos()
    {
        return view('sistema.pedido.indexRecibidos');
    }    

    public function getdata()
    {
        $persona = Persona::find(Auth::user()->fkpersona);

        $query = factura::join('persona_nivel', 'pedido.fkpersonivel' ,'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel' ,'nivel.id')
            ->join('descuento', 'nivel.fkdescuento' ,'descuento.id')
            ->where('pedido.estado', 1)
            ->where('pedido.fkcodigo', $persona->codigo)
            ->select(['pedido.id as id', 'nivel.nombre as nivel', 'porcentaje', 'pedido.fecha as fecha', 
                    'subtotal', 'total', \DB::raw("(SELECT CONCAT(nombre1,' ',IFNULL(nombre2,''),' ',apellido1,' ',IFNULL(apellido2,'')) FROM persona p
                              WHERE p.id = '".$persona->id_padre."') as distribuidor"), 'pagado']);

        return Datatables::of($query)
            ->addColumn('numero', function ($data) {
                return $data->id;
            })        
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })         
            ->addColumn('descuento', function ($data) {
                return $data->nivel.' - '.$data->porcentaje.'%';
            })  
            ->addColumn('estado_pago', function ($data) {
                if($data->pagado == 1)
                    return 'Pagado';
                else
                    return 'No Pagado';
            })                        
            ->addColumn('action', function ($data) {
                $btn_cancelar = '';
                $btn_pagar = '';
                $detalle_venta = '<button class="venta-modal btn btn-success btn-xs" 
                type="button" data-id="'.$data->id.'">Agregar Productos</button>'; 
                $pedido_aceptado = '';

                $aceptados = PedidoAceptado::where('fkpedido', $data->id)->get();
                $solictados = DetalleVenta::where('fkpedido', $data->id)->get();
                
                if(count($solictados) > 0)
                {
                    if(count($aceptados) == count($solictados) && $data->pagado == 0)
                    {
                        $btn_pagar = '<button class="pagar-modal btn btn-primary btn-xs" 
                        type="button" data-id="'.$data->id.'">Pagar</button>';

                        $btn_cancelar = '<button class="cancelar-modal btn btn-danger btn-xs" 
                        type="button" data-id="'.$data->id.'">Cancelar</button>';                  
                    }
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
        $query = factura::join('persona', 'pedido.fkcodigo', 'persona.codigo')
            ->join('persona_nivel', 'pedido.fkpersonivel' ,'persona_nivel.id')
            ->join('nivel', 'persona_nivel.fknivel' ,'nivel.id')
            ->join('descuento', 'nivel.fkdescuento' ,'descuento.id')
            ->where('pedido.estado', 1)
            ->where('pedido.fkpersona', Auth::user()->fkpersona)
            ->select(['pedido.id as id', 'nivel.nombre as nivel', 'porcentaje', 'fecha', 
                    'subtotal', 'total', 'codigo', 'nombre1', 'nombre2', 'apellido1', 'apellido2', 'pagado']);

        return Datatables::of($query)
            ->addColumn('numero', function ($data) {
                return $data->id;
            })        
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha));
            })         
            ->addColumn('descuento', function ($data) {
                return $data->nivel.' - '.$data->porcentaje.'%';
            })  
            ->addColumn('estado_pago', function ($data) {
                if($data->pagado == 1)
                    return 'Pagado';
                else
                    return 'No Pagado';
            })              
            ->addColumn('asociado', function ($data) {
                return $data->codigo.'-'.$data->nombre1.' '.$data->apellido1;
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
            $data = factura::find($id);
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
            ->where('persona_nivel.fkpersona', Auth::user()->fkpersona)
            ->select('persona_nivel.id as id')->first();

        if (is_null($nivel)) {
            return Response::json(array('errors' => 'error'));
        } else {
            $persona = Persona::find(Auth::user()->fkpersona);

            $data = new factura;
            $data->fkcodigo = $persona->codigo;
            $data->fkpersona = $persona->id_padre;
            $data->fkpersonivel = $nivel->id;
            $data->fecha = date("Y-m-d");       
            $data->subtotal = 0.00;
            $data->total =  0.00;
            $data->total =  0.00;                
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

    }

    public function pagado(Request $request)
    {
        if($request->ajax()){
            $data = factura::findOrFail($request->id);
            $data->pagado = 1;
            $data->save();
            return response()->json($data);
        }        
    }    

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = factura::findOrFail($request->id);
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
