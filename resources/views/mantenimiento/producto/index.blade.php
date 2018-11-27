@extends('adminlte::page')

@section('title', 'Mantenimiento - Producto')

@section('content_header')
    <div class="content-header">
        <h1>Producto  <button class="add-modal btn btn-primary btn-xs" 
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
                                        <th width="15%">Nombre</th>
                                        <th width="35%">Descripcion</th>
                                        <th width="10%">Punto</th>
                                        <th width="10%">Precio</th>
                                        <th width="15%">Categoria</th>
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
                        <div class="col-sm-12">
                            <label for="nombre_add">Nombre</label>
                            <input type="text" class="form-control" id="nombre_add">                                                             
                            <p class="erroNombre text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="col-sm-12">
                            <label for="fkcategoria_add">Categoria</label>
                            <select id="fkcategoria_add" class="form-control"></select>                                                           
                            <p class="erroFKCategoria text-center alert alert-danger hidden"></p>
                        </div>  
                        <div class="col-sm-6">
                            <label for="punto_add">Punto</label>
                            <input type="text" class="form-control" id="punto_add">                                                             
                            <p class="erroPunto text-center alert alert-danger hidden"></p>
                        </div> 
                        <div class="col-sm-6">
                            <label for="precio_add">Precio</label>
                            <input type="text" class="form-control" id="precio_add">                                                             
                            <p class="erroPrecio text-center alert alert-danger hidden"></p>
                        </div>  
                        <div class="col-sm-12">
                            <label for="descripcion_add">Descripcion</label>
                            <textarea id="descripcion_add" class="form-control"></textarea>                                                             
                            <p class="erroDescripcion text-center alert alert-danger hidden"></p>
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
    var id = 0;

    $(document).ready(function() {
        tabla = $('#info-table').DataTable({ 
            destroy: true,   
            processing: true,
            serverSide: false,
            paginate: true,
            searching: true,
            ajax: "{{ route('getdata.Producto') }}",
            columns: [
                { data: 'producto', name: 'producto' },   
                { data: 'descripcion', name: 'descripcion' }, 
                { data: 'punto', name: 'punto' }, 
                { data: 'precio', name: 'precio' },  
                { data: 'categoria', name: 'categoria' },                                  
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });  
    
    function dropCategoria(seleccionado) 
    {
        $.get("/drop/categoria", function(response) {
            $('#fkcategoria_add').empty();
            $('#fkcategoria_add').append('<option value="" selected>Seleccionar Uno</option>');
            
            if(seleccionado > 0)
            {
                for(i=0; i < response.length; i++)
                {
                    if(seleccionado == response[i].id)
                    {
                        $('#fkcategoria_add').append('<option value="'+response[i].id+'" selected>'+response[i].nombre+'</option>');
                    }
                    else
                    {
                        $('#fkcategoria_add').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
                    }
                }
            }
            else
            {
                for(i=0; i < response.length; i++)
                {
                    $('#fkcategoria_add').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
                }                
            }
        });
    }    

    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Informacion');

        $('.erroNombre').addClass('hidden');
        $('.erroFKCategoria').addClass('hidden');
        $('.erroPunto').addClass('hidden');
        $('.erroPrecio').addClass('hidden'); 
        $('.erroDescripcion').addClass('hidden'); 

        $('#nombre_add').val('');
        $('#punto_add').val('');  
        $('#precio_add').val('');
        $('#descripcion_add').val('');               
        id = 0;
        dropCategoria(0);

        $('#addModal').modal('show');
    }); 

    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Editar Informacion');
        $('.erroNombre').addClass('hidden');
        $('.erroFKCategoria').addClass('hidden');
        $('.erroPunto').addClass('hidden');
        $('.erroPrecio').addClass('hidden'); 
        $('.erroDescripcion').addClass('hidden'); 

        id = $(this).data('id');
        dropCategoria($(this).data('fkcategoria'));
        $('#nombre_add').val($(this).data('producto'));
        $('#punto_add').val($(this).data('punto'));  
        $('#precio_add').val($(this).data('precio'));
        $('#descripcion_add').val($(this).data('descripcion'));  

        $('#addModal').modal('show');
    });     

    $('.modal-footer').on('click', '.add', function() {
        if(id > 0)
        {
            $.ajax({
                type: 'PUT',
                url: '/Producto/'+id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $('#nombre_add').val(),
                    'punto': $('#punto_add').val(),
                    'precio': $('#precio_add').val(),
                    'descripcion': $('#descripcion_add').val(),
                    'fkcategoria': $('#fkcategoria_add').val(),                                         
                    'id': id,
                },
                success: function(data) {
                    $('.erroNombre').addClass('hidden');
                    $('.erroFKCategoria').addClass('hidden');
                    $('.erroPunto').addClass('hidden');
                    $('.erroPrecio').addClass('hidden'); 
                    $('.erroDescripcion').addClass('hidden'); 
    
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            swal("Error", "No se ingreso la informacion", "error", {
                              buttons: false,
                              timer: 2000,
                            });
                        }, 500);
    
                        if (data.errors.nombre) {
                            $('.erroNombre').removeClass('hidden');
                            $('.erroNombre').text(data.errors.nombre);
                        }
                        if (data.errors.fkcategoria) {
                            $('.erroFKCategoria').removeClass('hidden');
                            $('.erroFKCategoria').text(data.errors.fkcategoria);
                        } 
                        if (data.errors.punto) {
                            $('.erroPunto').removeClass('hidden');
                            $('.erroPunto').text(data.errors.punto);
                        }
                        if (data.errors.precio) {
                            $('.erroPrecio').removeClass('hidden');
                            $('.erroPrecio').text(data.errors.precio);
                        } 
                        if (data.errors.descripcion) {
                            $('.erroDescripcion').removeClass('hidden');
                            $('.erroDescripcion').text(data.errors.descripcion);
                        }                                                       
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre_add').val('');
                            $('#punto_add').val('');  
                            $('#precio_add').val('');
                            $('#descripcion_add').val('');   
                            id = 0;
                            tabla.ajax.reload();
                        });                          
                    }
                },
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: '/Producto',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $('#nombre_add').val(),
                    'punto': $('#punto_add').val(),
                    'precio': $('#precio_add').val(),
                    'descripcion': $('#descripcion_add').val(),
                    'fkcategoria': $('#fkcategoria_add').val(),  
                },
                success: function(data) {
                    $('.erroNombre').addClass('hidden');
                    $('.erroFKCategoria').addClass('hidden');
                    $('.erroPunto').addClass('hidden');
                    $('.erroPrecio').addClass('hidden'); 
                    $('.erroDescripcion').addClass('hidden'); 
    
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            swal("Error", "No se ingreso la informacion", "error", {
                              buttons: false,
                              timer: 2000,
                            });
                        }, 500);
    
                        if (data.errors.nombre) {
                            $('.erroNombre').removeClass('hidden');
                            $('.erroNombre').text(data.errors.nombre);
                        }
                        if (data.errors.fkcategoria) {
                            $('.erroFKCategoria').removeClass('hidden');
                            $('.erroFKCategoria').text(data.errors.fkcategoria);
                        } 
                        if (data.errors.punto) {
                            $('.erroPunto').removeClass('hidden');
                            $('.erroPunto').text(data.errors.punto);
                        }
                        if (data.errors.precio) {
                            $('.erroPrecio').removeClass('hidden');
                            $('.erroPrecio').text(data.errors.precio);
                        } 
                        if (data.errors.descripcion) {
                            $('.erroDescripcion').removeClass('hidden');
                            $('.erroDescripcion').text(data.errors.descripcion);
                        } 
    
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre_add').val('');
                            $('#punto_add').val('');  
                            $('#precio_add').val('');
                            $('#descripcion_add').val('');   
                            id = 0;                            
                            tabla.ajax.reload();
                        });                          
                    }
                },
            });
        } 
    });

    $(document).on('click', '.delete-modal', function() {
        $.ajax({
            type: 'POST',
            url: '/estado/Producto',
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