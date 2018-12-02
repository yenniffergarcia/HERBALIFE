<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Descuento;

class DescuentoController extends Controller
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
        'porcentaje' => 'required|numeric|unique:descuento',                                  
    ];

    public function index()
    {
        return view('mantenimiento.descuento.index');
    }

    public function getdata()
    {
        $query = descuento::select(['id','porcentaje']);

        return Datatables::of($query)
            ->addColumn('action', function ($data) {

                $btn_edit = '<button class="edit-modal btn btn-warning 
                btn-xs" type="button" data-id="'.$data->id.'" 
                data-porcentaje="'.$data->porcentaje.'">Editar</button>';           

                return $btn_edit;
            })                  
            ->editColumn('id', 'ID: {{$id}}')       
            ->make(true);
    }

    public function buscar(Request $request, $id)
    {
        if($request->ajax()){
            $data = descuento::find($id);
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
            $data = new descuento;
            $data->porcentaje = $request->porcentaje;
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
            'porcentaje' => 'required|numeric|unique:descuento,porcentaje,'.$request->id,
        ]);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $data = descuento::findOrFail($request->id);
            $data->porcentaje = $request->porcentaje;
            $data->save();
            return response()->json($data);
        }
    }

    public function destroy($id)
    {

    }
}
