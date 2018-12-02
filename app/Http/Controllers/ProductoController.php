<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Producto;
use App\Categoria;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        $this->middleware('gerente');
        $this->middleware('asociado_interno', ['only' => ['index']]);
        $this->middleware('asociado_externo', ['only' => ['index']]);
    }
        
    protected $verificar_insert =
    [
        'nombre' => 'required|max:50|unique:producto',
        'fkcategoria' => 'required|integer',  
        'descripcion' => 'required|max:1000', 
        'punto' => 'required|numeric',                                
        'precio' => 'required|numeric', 
    ];

    public function index()
    {
        return view('mantenimiento.producto.index');
    }

    public function getdata()
    {
        $query = producto::join('categoria', 'producto.fkcategoria' ,'categoria.id')
            ->where('producto.estado', 1)
            ->select(['producto.id as id', 'descripcion', 'punto', 'precio', 
            'producto.nombre as producto', 'fkcategoria', 'categoria.nombre as categoria']);

        return Datatables::of($query)
            ->addColumn('action', function ($data) {

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-producto="'.$data->producto.'" data-descripcion="'.$data->descripcion.'" 
                data-punto="'.$data->punto.'" data-precio="'.$data->precio.'"  
                data-fkcategoria="'.$data->fkcategoria.'">Editar</button>';           

                return $btn_edit.'  '.$btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = producto::find($id);
            return response()->json($data);
        }        
    }  

    public function dropCategoria(Request $request)
    {
        if($request->ajax()){
            $data = categoria::where('estado', 1)->select('categoria.*')->get();
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
            $data = new producto;
            $data->nombre = $request->nombre;
            $data->descripcion = $request->descripcion;
            $data->punto = $request->punto;     
            $data->precio = $request->precio;                      
            $data->fkcategoria = $request->fkcategoria;
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
            'nombre' => 'required|max:50|unique:producto,nombre,'.$request->id,
            'fkcategoria' => 'required|integer',  
            'descripcion' => 'required|max:1000', 
            'punto' => 'required|numeric',                                
            'precio' => 'required|numeric',    
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = producto::findOrFail($request->id);
            $data->nombre = $request->nombre;
            $data->descripcion = $request->descripcion;
            $data->punto = $request->punto;     
            $data->precio = $request->precio;                      
            $data->fkcategoria = $request->fkcategoria;           
            $data->save();
            return response()->json($data);
        }
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = producto::findOrFail($request->id);
            $data->estado = 0;
            $data->save();
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}
