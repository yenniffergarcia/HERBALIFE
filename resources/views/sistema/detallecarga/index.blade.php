@extends('adminlte::page')

@section('title', 'Sistema - Carga Producto')

@section('content_header')
    <div class="content-header">
        <h1>Carga Producto  <button class="add-modal btn btn-primary btn-xs" 
        type="button">Nuevo</button></h1>                    
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
                                        <th width="11%">Cantidad</th>
                                        <th width="20%">Producto</th>
                                        <th width="11%">Precio</th>
                                        <th width="11%">Precio Total</th>
                                        <th width="11%">Punteo</th>
                                        <th width="11%">Punteo Total</th>
                                        <th width="10%">Fecha V.</th>
                                        <th width="15%">Opciones</th>
                                    </tr>
                                </thead>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="col-sm-6">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad">                                                             
                            <p class="erroCantidad text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="col-sm-6">
                            <label for="fecha_vencimiento">Fecha Vencimiento</label>
                            <input type="text" class="form-control" id="fecha_vencimiento">                                                             
                            <p class="erroFechaVencimiento text-center alert alert-danger hidden"></p>
                        </div>                        
                        <div class="col-sm-6">
                            <label for="fkcategoria">Categoria</label>
                            <select id="fkcategoria" onchange="dropProducto(this);" class="form-control"></select>                                                           
                        </div>     
                        <div class="col-sm-6">
                            <label for="fkproducto">Producto</label>
                            <select id="fkproducto" class="form-control"></select>                                                           
                            <p class="erroFKProducto text-center alert alert-danger hidden"></p>
                        </div>                                                                                                                
                    </form>
                </div>
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary add" data-dismiss="modal">
                        <span id="" class='fa fa-save'></span>
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        <span class='fa fa-ban'></span>
                    </button>
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
            ajax: "{{ route('getdata.DetalleCarga') }}",
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
    });  
    
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
    
    function dropProducto(id) 
    {
        $.get("/drop/producto/"+id.value, function(response) {
            $('#fkproducto').empty();
            $('#fkproducto').append('<option value="" selected>Seleccionar Uno</option>');

            for(i=0; i < response.length; i++)
            {
                $('#fkproducto').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
            }                
        });
    }    

    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Informacion');

        $('.erroCantidad').addClass('hidden');
        $('.erroFechaVencimiento').addClass('hidden');
        $('.erroFKProducto').addClass('hidden'); 

        $('#cantidad').val('');
        $('#fecha_vencimiento').val('');  
        $('#fkproducto').val('');

        dropCategoria();

        $('#addModal').modal('show');
    });     

    $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'POST',
            url: '/DetalleCarga',
            data: {
                '_token': $('input[name=_token]').val(),
                'cantidad': $('#cantidad').val(),
                'fecha_vencimiento': $('#fecha_vencimiento').val(),
                'fkproducto': $('#fkproducto').val(), 
            },
            success: function(data) {
                $('.erroCantidad').addClass('hidden');
                $('.erroFechaVencimiento').addClass('hidden');
                $('.erroFKProducto').addClass('hidden'); 

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#addModal').modal('show');
                        swal("Error", "No se ingreso la informacion", "error", {
                            buttons: false,
                            timer: 2000,
                        });
                    }, 500);

                    if (data.errors.cantidad) {
                        $('.erroCantidad').removeClass('hidden');
                        $('.errerroCantidadNombre').text(data.errors.cantidad);
                    }
                    if (data.errors.fecha_vencimiento) {
                        $('.erroFechaVencimiento').removeClass('hidden');
                        $('.erroFechaVencimiento').text(data.errors.fecha_vencimiento);
                    } 
                    if (data.errors.fkproducto) {
                        $('.erroFKProducto').removeClass('hidden');
                        $('.erroFKProducto').text(data.errors.punto);
                    }

                } else {
                    swal("Correcto", "Se ingreso la informacion", "success")
                    .then((value) => {
                        $('#cantidad').val('');
                        $('#fecha_vencimiento').val('');  
                        $('#fkproducto').val('');                       
                        tabla.ajax.reload();
                    });                          
                }
            },
        });
    });

    $(document).on('click', '.delete-modal', function() {
        $.ajax({
            type: 'POST',
            url: '/estado/DetalleCarga',
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
                    swal("Correcto", "Se elimino la informacion", "success")
                    .then((value) => {
                        id = 0;                            
                        tabla.ajax.reload();
                    });                          
                }
            },
        });
    });     

    </script>
@stop