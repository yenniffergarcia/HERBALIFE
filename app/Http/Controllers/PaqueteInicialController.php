<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\PaqueteInicial;

class PaqueteInicialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }    
    
    protected $verificar_insert =
    [
        'nombre' => 'required|max:75|unique:paquete_inicial',                                  
    ];

    public function index()
    {
        return view('mantenimiento.paqueteinicial.index');
    }

    public function getdata()
    {
        $query = paqueteinicial::where('estado', 1)->select(['id','nombre']);

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
            $data->save();
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}