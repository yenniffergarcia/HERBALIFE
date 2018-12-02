<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Stock;
use Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('gerente');
        //$this->middleware('asociado_interno');
        //$this->middleware('asociado_externo');
    }

    public function index()
    {
        return view('sistema.stock.index');
    }

    public function getdata()
    {
        $query = stock::join('producto', 'stock.fkproducto', 'producto.id')
            ->join('categoria', 'producto.fkcategoria', 'categoria.id')
            ->where('fkpersona', Auth::user()->fkpersona)
            ->select(['categoria.nombre as categoria', 'producto.nombre as producto',
            'cantidad']);

        return Datatables::of($query)
            ->addColumn('producto', function ($data) {
                return $data->categoria.' / '.$data->producto;
            })->make(true);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

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

    public function destroy($id)
    {

    }
}
