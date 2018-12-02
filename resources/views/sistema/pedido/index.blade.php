@extends('adminlte::page')

@section('title', 'Sistema - Pedidos')

@section('content_header')
    <div class="content-header">
        <h1>Pedidos  {!! $button !!}</h1>                    
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
                                        <th width="15%">Distribuidor</th>
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
                    <h4 class="modal-title-detalle"></h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="col-sm-3">
                            <label for='cantidad'>Cantidad</label>
                            <input type="number" id="cantidad" class="form-control">
                            <p class="erroCantidad text-center alert alert-danger hidden"></p>
                        </div>    
                        <div class="col-sm-4">
                            <label for="fkcategoria">Categoria</label>
                            <select id="fkcategoria" onchange="dropStock(this);" class="form-control"></select>
                        </div>                                                               
                        <div class="col-sm-5">
                            <label for="fkstock">Producto</label>
                            <select id="fkstock" class="form-control"></select>  
                            <p class="erroFKStock text-center alert alert-danger hidden"></p>
                        </div>                    
                    </form>
                </div>
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary add-producto" data-dismiss="modal">
                        <span class='fa fa-save'></span>
                    </button>
                </div>
                <div class="row"></div>

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
            ajax: "{{ route('getdata.Pedido') }}",
            columns: [
                { data: 'numero', name: 'numero' },  
                { data: 'descuento', name: 'descuento' },   
                { data: 'fecha', name: 'fecha' }, 
                { data: 'subtotal', name: 'subtotal' }, 
                { data: 'total', name: 'total' }, 
                { data: 'distribuidor', name: 'distribuidor' }, 
                { data: 'estado_pago', name: 'estado_pago' },                                 
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });  

    $(document).on('click', '.add-modal', function() {
        $.ajax({
            type: 'POST',
            url: '/Pedido',
            data: {
                '_token': $('input[name=_token]').val(), 
            },
            success: function(data) {
                if ((data.errors)) {
                    setTimeout(function () {
                        swal("Error", "No se ingreso la informacion", "error", {
                          buttons: false,
                          timer: 2000,
                        });
                    }, 500);                       
                } else {
                    swal("Correcto", "Se ingreso la informacion", "success")
                    .then((value) => {  
                        tabla.ajax.reload();
                    });                          
                }
            },
        });
    }); 


    $(document).on('click', '.pagar-modal', function() 
    {
        $.ajax({
            type: 'POST',
            url: '/pagado/Pedido',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $(this).data('id'),
            },
            success: function(data) {
                if ((data.errors)) {
                    setTimeout(function () {
                        swal("Error", "No se ingreso la informacion", "error", {
                          buttons: false,
                          timer: 2000,
                        });
                    }, 500);
                } else {
                    swal("Correcto", "Se ingreso la informacion", "success")
                    .then((value) => {
                        tabla.ajax.reload();
                    });                          
                }
            },
        });           

    });


    $(document).on('click', '.cancelar-modal', function() 
    {
        $.ajax({
            type: 'POST',
            url: '/estado/Pedido',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $(this).data('id'),
            },
            success: function(data) {
                if ((data.errors)) {
                    setTimeout(function () {
                        swal("Error", "No se ingreso la informacion", "error", {
                          buttons: false,
                          timer: 2000,
                        });
                    }, 500);
                } else {
                    swal("Correcto", "Se ingreso la informacion", "success")
                    .then((value) => {
                        tabla.ajax.reload();
                    });                          
                }
            },
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
        ruta_original = "{{ route('getdata.DetalleVenta', ['pedido' => 'ids']) }}";
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

    function dropCategoria() 
    {
        $.get("/drop/categoria", function(response) {
            $('#fkcategoria').empty();
            $('#fkcategoria').append('<option value="" selected>Seleccionar Uno</option>');

            for(i=0; i < response.length; i++)
            {
                $('#fkcategoria').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
            }                
        });
    }

    function dropStock(id) 
    {
        $.get("/drop/stock/producto/"+id.value, function(response) {
            $('#fkstock').empty();
            $('#fkstock').append('<option value="" selected>Seleccionar Uno</option>');

            for(i=0; i < response.length; i++)
            {
                $('#fkstock').append('<option value="'+response[i].id+'">'+response[i].producto+'</option>');
            }                
        });
    }     

    $(document).on('click', '.venta-modal', function() 
    {
        pedido = $(this).data('id');        
        $('.modal-title-producto-pedido').text('Agregar Producto al Pedido #'+pedido);

        dropCategoria();
        tablaDetalle(pedido);

        $('.erroCantidad').addClass('hidden'); 
        $('.erroFKStock').addClass('hidden'); 

        $('#cantidad').val('');
        $('#addProductosPedido').modal('show');
    });

    $('.modal-footer').on('click', '.add-producto', function() {

        $.get("/verificar/producto/detalle/"+$('#fkstock').val()+"/"+pedido, function(response) 
        {
            if(parseInt(response) == 1)
            {            
                $.ajax({
                    type: 'POST',
                    url: '/DetalleVenta',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'cantidad': $('#cantidad').val(),
                        'fkpedido': pedido,
                        'fkstock': $('#fkstock').val(),
                    },
                    success: function(data) {
                        $('.erroCantidad').addClass('hidden');
                        $('.erroFKStock').addClass('hidden');

                        if ((data.errors)) {
                            setTimeout(function () {
                                $('#addProductosPedido').modal('show');
                                swal("Error", "No se ingreso la informacion", "error", {
                                  buttons: false,
                                  timer: 2000,
                                });
                            }, 500);

                            if (data.errors.cantidad) {
                                $('.erroCantidad').removeClass('hidden');
                                $('.erroCantidad').text(data.errors.cantidad);
                            }
                            if (data.errors.fkstock) {
                                $('.erroFKStock').removeClass('hidden');
                                $('.erroFKStock').text(data.errors.fkstock);
                            } 

                        } else {
                            swal("Correcto", "Se ingreso la informacion", "success")
                            .then((value) => {
                                $('#addProductosPedido').modal('show');
                                $('#cantidad').val('');
                                dropCategoria();
                                tablaDetalle(pedido);
                                tabla.ajax.reload();
                            });                          
                        }
                    },
                });
            }   
            else
            {
                swal("Advertencia", "Crear otro pedido para productos repetidos", "warning", {
                  buttons: false,
                  timer: 2000,
                });
            } 
        });
    });  

    $(document).on('click', '.eliminar-modal', function() 
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
                        $('#cantidad').val('');
                        dropCategoria();
                        tablaDetalle(pedido);
                        tabla.ajax.reload();
                    });                          
                }
            },
        });           

    });      

    </script>
@stop