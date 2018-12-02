@extends('adminlte::page')

@section('title', 'Sistema - Pedidos')

@section('content_header')
    <div class="content-header">
        <h1>Pedidos Recibidos</h1>                    
    </div>    
@stop

@section('content')
    
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">INFORMACION</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <br>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-bordered table-hover dataTable" id="info-table" width="100%">
                                <thead >
                                    <tr>
                                        <th width="10%"># Pedido</th>
                                        <th width="15%">Descuento</th>
                                        <th width="10%">Fecha</th>
                                        <th width="10%">Sub Total</th>
                                        <th width="10%">Total</th>
                                        <th width="15%">Asociado</th>
                                        <th width="10%">Pagado</th>
                                        <th width="20%">Opciones</th>
                                    </tr>
                                </thead>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Agregar Productos al Pedido -->
    <div id="addProductosPedido" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title-producto-pedido"></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <br>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered table-hover dataTable" id="info-detalle" width="100%">
                                        <thead >
                                            <tr>
                                                <th width="10%">Cantidad</th>
                                                <th width="15%">Producto</th>
                                                <th width="10%">Precio</th>
                                                <th width="10%">Precio Total</th>
                                                <th width="10%">Puntos</th>
                                                <th width="15%">Puntos Total</th>
                                                <th width="10%">Fecha</th>
                                                <th width="20%">Opciones</th>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
    </div>    


    <!-- Modal Mostrar Detalle Historico -->
    <div id="mostrarDetalleHistorico" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title-detalle"></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <br>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered table-hover dataTable" id="info-detalle-historico" width="100%">
                                        <thead >
                                            <tr>
                                                <th width="10%">Cantidad</th>
                                                <th width="25%">Producto</th>
                                                <th width="10%">Precio</th>
                                                <th width="10%">Precio Total</th>
                                                <th width="10%">Puntos</th>
                                                <th width="15%">Puntos Total</th>
                                                <th width="10%">Fecha</th>
                                                <th width="10%">Estado</th>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>  


    <!-- Modal Mostrar Detalle Historico Aceptado -->
    <div id="mostrarDetallaHistoricoAceptado" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title-aceptado"></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <br>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered table-hover dataTable" id="info-detalle-historico-aceptado" width="100%">
                                        <thead >
                                            <tr>
                                                <th width="10%">Cantidad</th>
                                                <th width="35%">Producto</th>
                                                <th width="10%">Precio</th>
                                                <th width="10%">Precio Total</th>
                                                <th width="10%">Puntos</th>
                                                <th width="15%">Puntos Total</th>
                                                <th width="10%">Fecha</th>
                                            </tr>
                                        </thead>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>   


    <!-- AJAX CRUD operations -->
    <script type="text/javascript">


    $(document).ready(function() {
        tabla = $('#info-table').DataTable({ 
            destroy: true,   
            processing: true,
            serverSide: false,
            paginate: true,
            searching: true,
            ajax: "{{ route('getpedido.Pedido') }}",
            columns: [
                { data: 'numero', name: 'numero' },  
                { data: 'descuento', name: 'descuento' },   
                { data: 'fecha', name: 'fecha' }, 
                { data: 'subtotal', name: 'subtotal' }, 
                { data: 'total', name: 'total' }, 
                { data: 'asociado', name: 'asociado' }, 
                { data: 'estado_pago', name: 'estado_pago' },                                 
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });  


    // ------ Ver Historicos del Pedido en Detalle Venta y Productos Aceptados

    $(document).on('click', '.detalle-modal', function() {
        $('.modal-title-detalle').text('Productos solicitados en el Pedido #'+$(this).data('id'));
        let ruta_original = null;
        ruta_original = "{{ route('getdataHistorico.DetalleVenta', ['pedido' => 'ids']) }}";
        var ruta_consulta = ruta_original.replace('ids', $(this).data('id'));

        $('#info-detalle-historico').DataTable({ 
            destroy: true,   
            processing: true,
            serverSide: false,
            paginate: true,
            searching: true,
            ajax: ruta_consulta,
            columns: [
                { data: 'cantidad', name: 'cantidad' },  
                { data: 'nombre', name: 'nombre' },   
                { data: 'precio', name: 'precio' }, 
                { data: 'total_precio', name: 'total_precio' }, 
                { data: 'punto', name: 'punto' }, 
                { data: 'total_punto', name: 'total_punto' }, 
                { data: 'fecha', name: 'fecha' },                                 
                { data: 'vista', name: 'vista'}
            ]
        });

        $('#mostrarDetalleHistorico').modal('show');
    });    


    $(document).on('click', '.aceptado-modal', function() {
        $('.modal-title-aceptado').text('Productos aceptados en el Pedido #'+$(this).data('id'));
        let ruta_original = null;
        ruta_original = "{{ route('getaceptado.DetalleVenta', ['pedido' => 'ids']) }}";
        var ruta_consulta = ruta_original.replace('ids', $(this).data('id'));

        $('#info-detalle-historico-aceptado').DataTable({ 
            destroy: true,   
            processing: true,
            serverSide: false,
            paginate: true,
            searching: true,
            ajax: ruta_consulta,
            columns: [
                { data: 'cantidad', name: 'cantidad' },  
                { data: 'nombre', name: 'nombre' },   
                { data: 'precio', name: 'precio' }, 
                { data: 'total_precio', name: 'total_precio' }, 
                { data: 'punto', name: 'punto' }, 
                { data: 'total_punto', name: 'total_punto' }, 
                { data: 'fecha', name: 'fecha' },                                 
            ]
        });

        $('#mostrarDetallaHistoricoAceptado').modal('show');
    });


    // ------- Agregar productos al Pedido -------------

    var pedido = 0;

    function tablaDetalle(id) 
    {

        let ruta_original = null;
        ruta_original = "{{ route('getpedido.DetalleVenta', ['pedido' => 'ids']) }}";
        var ruta_consulta = ruta_original.replace('ids', id);

        $('#info-detalle').DataTable({ 
            destroy: true,   
            processing: true,
            serverSide: false,
            paginate: true,
            searching: true,
            ajax: ruta_consulta,
            columns: [
                { data: 'cantidad', name: 'cantidad' },  
                { data: 'nombre', name: 'nombre' },   
                { data: 'precio', name: 'precio' }, 
                { data: 'total_precio', name: 'total_precio' }, 
                { data: 'punto', name: 'punto' }, 
                { data: 'total_punto', name: 'total_punto' }, 
                { data: 'fecha', name: 'fecha' },                                 
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    }    

    $(document).on('click', '.venta-modal', function() 
    {
        pedido = $(this).data('id');        
        $('.modal-title-producto-pedido').text('Listado de Productos del Pedido #'+pedido);

        tablaDetalle(pedido);

        $('#addProductosPedido').modal('show');
    });

    $(document).on('click', '.si-modal', function() 
    {
        fkstock = $(this).data('fkstock');
        cantidad = $(this).data('cantidad');
        fkpedido = $(this).data('fkpedido');
        
        $.get("/verificar/stock/producto/"+$(this).data('fkstock')+"/"+$(this).data('cantidad'), function(response) 
        {
            if(parseInt(response) == 1)
            {
                console.log(fkstock, cantidad, fkpedido);
                $.ajax({
                    type: 'POST',
                    url: '/storeAprobado/DetalleVenta',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'cantidad': cantidad,
                        'fkpedido': fkpedido,
                        'fkstock': fkstock,
                    },
                    success: function(data) {
                        if ((data.errors)) {
                            setTimeout(function () {
                                $('#addProductosPedido').modal('show');
                                swal("Error", "No se ingreso la informacion", "error", {
                                  buttons: false,
                                  timer: 2000,
                                });
                            }, 500);
                        } else {
                            swal("Correcto", "Se ingreso la informacion", "success")
                            .then((value) => {
                                $('#addProductosPedido').modal('show');
                                tablaDetalle(pedido);
                                tabla.ajax.reload();
                            });                          
                        }
                    },
                });
            }   
            else
            {
                swal("Advertencia", "No hay suficiente Stock", "warning", {
                  buttons: false,
                  timer: 2000,
                });
            }          
        });
    });


    $(document).on('click', '.no-modal', function() 
    {
        $.ajax({
            type: 'POST',
            url: '/estado/DetalleVenta',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $(this).data('id'),
            },
            success: function(data) {
                if ((data.errors)) {
                    setTimeout(function () {
                        $('#addProductosPedido').modal('show');
                        swal("Error", "No se ingreso la informacion", "error", {
                          buttons: false,
                          timer: 2000,
                        });
                    }, 500);
                } else {
                    swal("Correcto", "Se ingreso la informacion", "success")
                    .then((value) => {
                        $('#addProductosPedido').modal('show');
                        tablaDetalle(pedido);
                        tabla.ajax.reload();
                    });                          
                }
            },
        });           

    });             

    </script>
@stop