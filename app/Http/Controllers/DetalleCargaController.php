<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\DetalleCarga;
use App\Producto;
use App\Stock;
use Auth;

class DetalleCargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('gerente');
        //$this->middleware('asociado_interno');
        $this->middleware('asociado_externo');
    }

    protected $verificar_insert =
    [
        'cantidad' => 'required|integer',
        'fkproducto' => 'required|integer', 
        'fecha_vencimiento' => 'required|date_format:"d-m-Y"',                                 
    ];

    public function index()
    {
        return view('sistema.detallecarga.index');
    }

    public function getdata()
    {
        $query = detallecarga::join('producto', 'detalle_carga.fkproducto' ,'producto.id')
            ->where('detalle_carga.estado', 1)
            ->where('fkpersona', Auth::user()->fkpersona)
            ->select(['detalle_carga.id as id', 'cantidad', 'fecha_vencimiento', 'fkproducto', 
                    'nombre', 'punto', 'precio']);

        return Datatables::of($query)
            ->addColumn('fecha', function ($data) {
                return date("d/m/Y", strtotime($data->fecha_vencimiento));
            })        
            ->addColumn('total_precio', function ($data) {
                return $data->cantidad * $data->precio;
            })
            ->addColumn('total_punto', function ($data) {
                return $data->cantidad * $data->punto;
            })                     
            ->addColumn('action', function ($data) {

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                return $btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = detallecarga::find($id);
            return response()->json($data);
        }        
    }  

    public function dropProducto(Request $request, $categoria)
    {
        if($request->ajax()){
            $data = producto::where('fkcategoria', $categoria)->where('estado', 1)
                    ->select('producto.*')->get();
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
            $data = new detallecarga;
            $data->fkpersona = Auth::user()->fkpersona;
            $data->fkproducto = $request->fkproducto;
            $data->cantidad = $request->cantidad;
            $data->fecha_vencimiento = date("Y-m-d", strtotime($request->fecha_vencimiento));            
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
        /*$validator = Validator::make(Input::all(),        
        [
            'cantidad' => 'required|integer',
            'fkproducto' => 'required|integer', 
            'fecha_vencimiento' => 'required|date_format:"d/m/Y"', 
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = detallecarga::findOrFail($request->id);
            $data->fkproducto = $request->fkproducto;
            $data->cantidad = $request->cantidad;
            $data->fecha_vencimiento = date("Y-m-d", strtotime($request->fecha_vencimiento));           
            $data->save();
            return response()->json($data);
        }*/
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = detallecarga::findOrFail($request->id);
            
            $stock = Stock::where('fkpersona', $data->fkpersona)
                ->where('fkproducto', $data->fkproducto)
                ->where('fecha_vencimiento', $data->fecha_vencimiento)
                ->first();
            if(($stock->cantidad - $data->cantidad) >= 0)
            {
                $data->estado = 0;
                $data->save();
            }
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}
