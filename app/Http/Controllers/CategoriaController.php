<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Categoria;

class CategoriaController extends Controller
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
        'nombre' => 'required|max:50|unique:categoria',                                  
    ];

    public function index()
    {
        return view('mantenimiento.categoria.index');
    }

    public function getdata()
    {
        $query = Categoria::where('estado', 1)->select(['id','nombre']);

        return Datatables::of($query)
            ->addColumn('action', function ($data) {

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-nombre="'.$data->nombre.'">Editar</button>';           

                return $btn_edit.'  '.$btn_estado;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = Categoria::find($id);
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
            $data = new Categoria;
            $data->nombre = $request->nombre;
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
            'nombre' => 'required|max:50|unique:categoria,nombre,'.$request->id,
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = Categoria::findOrFail($request->id);
            $data->nombre = $request->nombre;
            $data->save();
            return response()->json($data);
        }
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = Categoria::findOrFail($request->id);
            $data->estado = 0;
            $data->save();
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}
