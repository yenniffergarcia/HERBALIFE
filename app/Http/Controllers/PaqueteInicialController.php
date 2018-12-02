<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\PaqueteInicial;
use App\PaqueteProducto;

class PaqueteInicialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        $this->middleware('gerente');
        $this->middleware('asociado_interno');
        $this->middleware('asociado_externo');
    }    
    
    protected $verificar_insert =
    [
        'nombre' => 'required|max:75|unique:paquete_inicial',                                  
    ];

    protected $verificar_insert_producto =
    [
        'fkproducto' => 'required|integer', 
        'fkpaquete' => 'required|integer',                                     
    ];    

    public function index()
    {
        return view('mantenimiento.paqueteinicial.index');
    }

    public function getdata()
    {
        $query = paqueteinicial::where('estado', 1)->select(['id','nombre']);

        return Datatables::of($query)
            ->addColumn('puntos', function ($data) {
                $punteo = 0;
          
                $buscar = PaqueteProducto::join('producto', 'paquete_producto.fkproducto', 'producto.id')
                    ->where('fkpaquete', $data->id)->where('paquete_producto.estado', 1)
                    ->select('punto')->get();

                foreach($buscar as $value)
                {
                    $punteo = $value->punto + $punteo;
                }

                return $punteo;
            })        
            ->addColumn('action', function ($data) {
                
                $btn_producto = '<button class="agregar-modal btn btn-success btn-xs" 
                type="button" data-id="'.$data->id.'">Producto</button>';

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-nombre="'.$data->nombre.'">Editar</button>';           

                return $btn_edit.'  '.$btn_producto.'  '.$btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function getdataproducto($paquete)
    {
        $query = PaqueteProducto::join('producto', 'paquete_producto.fkproducto', 'producto.id')
        ->join('categoria', 'producto.fkcategoria', 'categoria.id')
        ->where('paquete_producto.fkpaquete', $paquete)
        ->where('paquete_producto.estado', 1)
        ->select(['paquete_producto.id as id', 'descripcion', 'punto', 'precio', 
        'producto.nombre as producto', 'categoria.nombre as categoria']);

        return Datatables::of($query)
            ->addColumn('producto', function ($data) {
                return $data->categoria.' / '.$data->producto;
            })         
            ->addColumn('action', function ($data) {
                
                $btn_estado = '<button class="delete-producto-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';         

                return $btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }    

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = paqueteinicial::find($id);
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
            $data = new paqueteinicial;
            $data->nombre = $request->nombre;
            $data->save();
            return response()->json($data);
        } 
    }

    public function storeProducto(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->verificar_insert_producto);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = new PaqueteProducto;
            $data->fkproducto = $request->fkproducto;
            $data->fkpaquete = $request->fkpaquete;
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
        $validator = Validator::make(Input::all(),        
        [
            'nombre' => 'required|max:75|unique:paquete_inicial,nombre,'.$request->id,
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = paqueteinicial::findOrFail($request->id);
            $data->nombre = $request->nombre;
            $data->save();
            return response()->json($data);
        }
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = paqueteinicial::findOrFail($request->id);
            $data->estado = 0;
            if($data->save())
            {
                $buscar = PaqueteProducto::where('fkpaquete', $request->id)->select('id')->get();

                foreach($buscar as $value)
                {
                    $eliminar = PaqueteProducto::findOrFail($value->id);
                    $eliminar->estado = 0;
                    $eliminar->save();
                }
            }
            return response()->json($data);
        }        
    } 

    public function estadoProducto(Request $request)
    {
        if($request->ajax())
        {
            $data = PaqueteProducto::findOrFail($request->id);
            $data->estado = 0;
            $data->save();
            return response()->json($data);
        }        
    }     

    public function destroy($id)
    {

    }
}
