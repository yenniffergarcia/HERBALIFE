<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Nivel;
use App\Descuento;

class NivelController extends Controller
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
        'nombre' => 'required|max:50|unique:nivel',
        'fkdescuento' => 'required|integer',                                 
    ];

    public function index()
    {
        return view('mantenimiento.nivel.index');
    }

    public function getdata()
    {
        $query = nivel::join('descuento', 'nivel.fkdescuento' ,'descuento.id')->where('estado', 1)
            ->select(['nivel.id as id', 'nombre', 'fkdescuento', 'porcentaje']);

        return Datatables::of($query)
            ->addColumn('action', function ($data) {

                $btn_estado = '<button class="delete-modal btn btn-danger btn-xs" 
                type="button" data-id="'.$data->id.'">Eliminar</button>';

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-nombre="'.$data->nombre.'" data-fkdescuento="'.$data->fkdescuento.'">Editar</button>';           

                return $btn_edit;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = nivel::find($id);
            return response()->json($data);
        }        
    }  

    public function dropDescuento(Request $request)
    {
        if($request->ajax()){
            $data = descuento::select('descuento.*')->get();
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
            $data = new nivel;
            $data->nombre = $request->nombre;
            $data->fkdescuento = $request->fkdescuento;
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
            'nombre' => 'required|max:50|unique:nivel,nombre,'.$request->id,
            'fkdescuento' => 'required|integer',   
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = nivel::findOrFail($request->id);
            $data->nombre = $request->nombre;
            $data->fkdescuento = $request->fkdescuento;            
            $data->save();
            return response()->json($data);
        }
    }

    public function estado(Request $request)
    {
        if($request->ajax()){
            $data = nivel::findOrFail($request->id);
            $data->estado = 0;
            $data->save();
            return response()->json($data);
        }        
    } 

    public function destroy($id)
    {

    }
}
