@extends('adminlte::page')

@section('title', 'Mantenimiento - Categoria')

@section('content_header')
    <div class="content-header">
        <h1>Categoria  <button class="add-modal btn btn-primary btn-xs" 
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
                                        <th width="75%">Nombre</th>
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
            ajax: "{{ route('getdata.Categoria') }}",
            columns: [
                { data: 'nombre', name: 'nombre' },                                     
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });    

    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Informacion');
        $('.erroNombre').addClass('hidden');
        $('#nombre_add').val('');
        id = 0;
        $('#addModal').modal('show');
    }); 

    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Editar Informacion');
        $('.erroNombre').addClass('hidden');

        id = $(this).data('id');
        $('#nombre_add').val($(this).data('nombre'));

        $('#addModal').modal('show');
    });     

    $('.modal-footer').on('click', '.add', function() {
        if(id > 0)
        {
            $.ajax({
                type: 'PUT',
                url: '/Categoria/'+id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $('#nombre_add').val(),
                    'id': id,
                },
                success: function(data) {
                    $('.erroNombre').addClass('hidden');
    
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
    
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre_add').val('');
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
                url: '/Categoria',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $('#nombre_add').val(),
                },
                success: function(data) {
                    $('.erroNombre').addClass('hidden');
    
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
    
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre_add').val('');
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
            url: '/estado/Categoria',
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