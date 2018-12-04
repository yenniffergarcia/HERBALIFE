@extends('adminlte::page')

@section('title', 'Sistema - Reporteria')

@section('content_header')
    <div class="content-header">
        <h1>Reporteria  </h1>                    
    </div>    
@stop

@section('content')
    
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Reporteria de Pedidos</h3>
        </div>
        <div class="box-header with-border">
            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('filtrar.pedido') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6">
                    <label for="fkproducto">Productos</label>
                    <select id="fkproducto" class="form-control" >
                        <option value="0" selected>Seleccionar Uno</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-5">
                    <label for="fknivel">Niveles</label>
                    <select id="fknivel" class="form-control" >
                        <option value="0" selected>Seleccionar Uno</option>
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                        @endforeach
                    </select>
                </div>  
                <div class="col-sm-1">
                    <br>
                    <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                </div>
            </form>                  
            </div>
        </div>        

        <div class="box-body">
            @if(!$pedidos->isEmpty())
            <div class="row pull-right">
                <button class="btn btn-warning btn-sm imprimirBtn">Imprimir</button>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>Pedido #</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td> {{ $pedido->id }} </td>
                                <td> {{ $pedido->fecha }} </td>
                                <td> 
                                    <table class="table no-margin">
                                        <thead>
                                            <th>Cantidad</th>
                                            <th>Producto</th>
                                            <th>Punto</th>
                                            <th>Punto Total</th>
                                        </thead>
                                        <tbody>                                            
                                            @foreach($productos as $producto)
                                                @if($pedido->id == $producto->fkpedido)
                                                    <tr>
                                                        <td> {{ $producto->cantidad }} </td>
                                                        <td> {{ $producto->producto }} </td>
                                                        <td> {{ $producto->punto }} </td>
                                                        <td> {{ $producto->cantidad * $producto->punto }} </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table> 
                                </td>
                                <td> {{ $pedido->subtotal }} </td>
                                <td> {{ $pedido->total }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        
        $(document).on('click', '.imprimirBtn', function() {
            
            var producto = $('#fkproducto').val();
            var nivel = $('#fknivel').val();

            console.log(producto, nivel);

            let ruta_original = "{{ route('imprimir.pedido', ['fkproducto' => 'idProducto', 'fkpersonivel' => 'idNivel']) }}";
            var ruta_producto = ruta_original.replace('idProducto', producto);
            var ruta_nivel = ruta_producto.replace('idNivel', nivel);

            $.ajax({
                type: 'GET',
                url: ruta_nivel,
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {   
                    window.location.replace(ruta_nivel);                                                               
                }
            });         

        });  

    </script>

@stop