@extends('adminlte::page')

@section('title', 'Sistema - Persona')

@section('content_header')
    <div class="content-header">
        <h1>Persona  <button class="add-modal btn btn-primary btn-xs" 
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
                                        <th width="10%">Codigo</th>
                                        <th width="20%">Persona</th>
                                        <th width="25%">Residencia</th>
                                        <th width="15%">Email</th>
                                        <th width="15%">Usuario</th>
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
                            <label for="nombre1">Primer Nombre</label>
                            <input type="text" class="form-control" id="nombre1">                                                             
                            <p class="erroNombre1 text-center alert alert-danger hidden"></p>
                        </div>
                        <div class="col-sm-6">
                            <label for="nombre2">Segundo Nombre</label>
                            <input type="text" class="form-control" id="nombre2">                                                             
                            <p class="erroNombre2 text-center alert alert-danger hidden"></p>
                        </div>   
                        <div class="col-sm-4">
                                <label for="apellido1">Primer Apellido</label>
                                <input type="text" class="form-control" id="apellido1">                                                             
                                <p class="erroApellido1 text-center alert alert-danger hidden"></p>
                            </div>
                        <div class="col-sm-4">
                            <label for="apellido2">Segundo Apellido</label>
                            <input type="text" class="form-control" id="apellido2">                                                             
                            <p class="erroApellido2 text-center alert alert-danger hidden"></p>
                        </div>  
                        <div class="col-sm-4">
                            <label for="apellido3">Tercer Apellido</label>
                            <input type="text" class="form-control" id="apellido3">                                                             
                            <p class="erroApellido3 text-center alert alert-danger hidden"></p>
                        </div>                                                                        
                        <div class="col-sm-6">
                            <label for="fkdepartamento">Departamento</label>
                            <select id="fkdepartamento" class="form-control"></select>                                                           
                            <p class="erroFKDepartamento text-center alert alert-danger hidden"></p>
                        </div>  
                        <div class="col-sm-6">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" id="email">                                                             
                            <p class="erroEmail text-center alert alert-danger hidden"></p>
                        </div> 
                        <div class="col-sm-12">
                            <label for="direccion">Direccion</label>
                            <textarea id="direccion" class="form-control"></textarea>                                                             
                            <p class="erroDireccion text-center alert alert-danger hidden"></p>
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


    <!-- Modal Agregar Producto Paquete -->
    <div id="addPaqueteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title-paquete"></h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">                     
                        <div class="col-sm-12">
                            <label for="fkpaquete">Paquete Incial</label>
                            <select id="fkpaquete" onchange="dropPaquetePersona(this);" class="form-control"></select>                                                           
                            <p class="erroFKPaquete text-center alert alert-danger hidden"></p>
                        </div>                                                                                                                  
                    </form>
                </div>
                <div class="row"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary add-paquete" data-dismiss="modal">
                        <span id="" class='fa fa-save'></span>
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        <span class='fa fa-ban'></span>
                    </button>
                </div>
                <div class="row"></div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="total_puntos" >Total de Puntos</label>
                            <input id="total_puntos" class="form-control" >
                        </div>
                        <div class="col-md-3">
                            <label for="sub_total" >Sub Total</label>
                            <input id="sub_total" class="form-control" >
                        </div>
                        <div class="col-md-3">
                            <label for="descuento" >Descuento</label>
                            <input id="descuento" class="form-control" >
                        </div>  
                        <div class="col-md-3">
                            <label for="total_precio" >Total de Precio</label>
                            <input id="total_precio" class="form-control" >
                        </div>  
                        <div class="col-md-12">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-bordered table-hover" width="100%">
                                    <thead >
                                        <tr>
                                            <th width="60%">Producto</th>
                                            <th width="20%">Precio</th>
                                            <th width="20%">Punteo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="info">
    
                                    </tbody>
                                </table> 
                            </div>
                        </div>                                     
                    </div>
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
            ajax: "{{ route('getdata.Persona') }}",
            columns: [
                { data: 'codigo', name: 'codigo' },  
                { data: 'persona', name: 'persona' },   
                { data: 'residencia', name: 'residencia' }, 
                { data: 'email', name: 'email' }, 
                { data: 'username', name: 'username' },                                 
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });  
    
    function dropDepartamento(seleccionado) 
    {
        $.get("/drop/departamento", function(response) {
            $('#fkdepartamento').empty();
            $('#fkdepartamento').append('<option value="" selected>Seleccionar Uno</option>');
            
            if(seleccionado > 0)
            {
                for(i=0; i < response.length; i++)
                {
                    if(seleccionado == response[i].id)
                    {
                        $('#fkdepartamento').append('<option value="'+response[i].id+'" selected>'+response[i].nombre+'</option>');
                    }
                    else
                    {
                        $('#fkdepartamento').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
                    }
                }
            }
            else
            {
                for(i=0; i < response.length; i++)
                {
                    $('#fkdepartamento').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
                }                
            }
        });
    }    

    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar Informacion');

        $('.erroNombre1').addClass('hidden');
        $('.erroNombre2').addClass('hidden');
        $('.erroApellido1').addClass('hidden');
        $('.erroApellido2').addClass('hidden'); 
        $('.erroApellido3').addClass('hidden'); 
        $('.erroFKDepartamento').addClass('hidden');
        $('.erroEmail').addClass('hidden');
        $('.erroDireccion').addClass('hidden');

        $('#nombre1').val('');
        $('#nombre2').val('');  
        $('#apellido1').val('');        
        $('#apellido2').val('');
        $('#apellido3').val('');  
        $('#email').val('');
        $('#direccion').val('');               
        id = 0;
        dropDepartamento(0);

        $('#addModal').modal('show');
    }); 

    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Editar Informacion');

        id = $(this).data('id');
        dropDepartamento($(this).data('fkdepartamento'));
        $('#nombre1').val($(this).data('nombre1'));
        $('#nombre2').val($(this).data('nombre2'));  
        $('#apellido1').val($(this).data('apellido1'));        
        $('#apellido2').val($(this).data('apellido2'));
        $('#apellido3').val($(this).data('apellido3'));  
        $('#email').val($(this).data('email'));
        $('#direccion').val($(this).data('direccion'));

        $('#addModal').modal('show');
    });     

    $('.modal-footer').on('click', '.add', function() {
        if(id > 0)
        {
            $.ajax({
                type: 'PUT',
                url: '/Persona/'+id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fkdepartamento': $('#fkdepartamento').val(),
                    'nombre1': $('#nombre1').val(),
                    'nombre2': $('#nombre2').val(),
                    'apellido1': $('#apellido1').val(),
                    'apellido2': $('#apellido2').val(),
                    'apellido3': $('#apellido3').val(),
                    'email': $('#email').val(),
                    'direccion': $('#direccion').val(),                                                           
                    'id': id,
                },
                success: function(data) {
                    $('.erroNombre1').addClass('hidden');
                    $('.erroNombre2').addClass('hidden');
                    $('.erroApellido1').addClass('hidden');
                    $('.erroApellido2').addClass('hidden'); 
                    $('.erroApellido3').addClass('hidden'); 
                    $('.erroFKDepartamento').addClass('hidden');
                    $('.erroEmail').addClass('hidden');
                    $('.erroDireccion').addClass('hidden');
    
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            swal("Error", "No se ingreso la informacion", "error", {
                              buttons: false,
                              timer: 2000,
                            });
                        }, 500);

                        if (data.errors.fkdepartamento) {
                            $('.erroNombre1').removeClass('hidden');
                            $('.erroNombre1').text(data.errors.fkdepartamento);
                        }
                        if (data.errors.nombre1) {
                            $('.erroNombre2').removeClass('hidden');
                            $('.erroNombre2').text(data.errors.nombre1);
                        } 
                        if (data.errors.nombre2) {
                            $('.erroApellido1').removeClass('hidden');
                            $('.erroApellido1').text(data.errors.nombre2);
                        }    
                        if (data.errors.apellido1) {
                            $('.erroApellido2').removeClass('hidden');
                            $('.erroApellido2').text(data.errors.apellido1);
                        }
                        if (data.errors.apellido2) {
                            $('.erroApellido3').removeClass('hidden');
                            $('.erroApellido3').text(data.errors.apellido2);
                        } 
                        if (data.errors.apellido3) {
                            $('.erroFKDepartamento').removeClass('hidden');
                            $('.erroFKDepartamento').text(data.errors.apellido3);
                        }
                        if (data.errors.email) {
                            $('.erroEmail').removeClass('hidden');
                            $('.erroEmail').text(data.errors.email);
                        } 
                        if (data.errors.direccion) {
                            $('.erroDireccion').removeClass('hidden');
                            $('.erroDireccion').text(data.errors.direccion);
                        }                                                       
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre1').val('');
                            $('#nombre2').val('');  
                            $('#apellido1').val('');        
                            $('#apellido2').val('');
                            $('#apellido3').val('');  
                            $('#email').val('');
                            $('#direccion').val('');   
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
                url: '/Persona',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fkdepartamento': $('#fkdepartamento').val(),
                    'nombre1': $('#nombre1').val(),
                    'nombre2': $('#nombre2').val(),
                    'apellido1': $('#apellido1').val(),
                    'apellido2': $('#apellido2').val(),
                    'apellido3': $('#apellido3').val(),
                    'email': $('#email').val(),
                    'direccion': $('#direccion').val(),   
                },
                success: function(data) {
                    $('.erroNombre1').addClass('hidden');
                    $('.erroNombre2').addClass('hidden');
                    $('.erroApellido1').addClass('hidden');
                    $('.erroApellido2').addClass('hidden'); 
                    $('.erroApellido3').addClass('hidden'); 
                    $('.erroFKDepartamento').addClass('hidden');
                    $('.erroEmail').addClass('hidden');
                    $('.erroDireccion').addClass('hidden');
    
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            swal("Error", "No se ingreso la informacion", "error", {
                              buttons: false,
                              timer: 2000,
                            });
                        }, 500);

                        if (data.errors.fkdepartamento) {
                            $('.erroNombre1').removeClass('hidden');
                            $('.erroNombre1').text(data.errors.fkdepartamento);
                        }
                        if (data.errors.nombre1) {
                            $('.erroNombre2').removeClass('hidden');
                            $('.erroNombre2').text(data.errors.nombre1);
                        } 
                        if (data.errors.nombre2) {
                            $('.erroApellido1').removeClass('hidden');
                            $('.erroApellido1').text(data.errors.nombre2);
                        }    
                        if (data.errors.apellido1) {
                            $('.erroApellido2').removeClass('hidden');
                            $('.erroApellido2').text(data.errors.apellido1);
                        }
                        if (data.errors.apellido2) {
                            $('.erroApellido3').removeClass('hidden');
                            $('.erroApellido3').text(data.errors.apellido2);
                        } 
                        if (data.errors.apellido3) {
                            $('.erroFKDepartamento').removeClass('hidden');
                            $('.erroFKDepartamento').text(data.errors.apellido3);
                        }
                        if (data.errors.email) {
                            $('.erroEmail').removeClass('hidden');
                            $('.erroEmail').text(data.errors.email);
                        } 
                        if (data.errors.direccion) {
                            $('.erroDireccion').removeClass('hidden');
                            $('.erroDireccion').text(data.errors.direccion);
                        }                                                       
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {
                            $('#nombre1').val('');
                            $('#nombre2').val('');  
                            $('#apellido1').val('');        
                            $('#apellido2').val('');
                            $('#apellido3').val('');  
                            $('#email').val('');
                            $('#direccion').val('');   
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
            url: '/estado/Persona',
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

    // --------------------- Agregar paquete a la persona y activar cuenta

    function dropPaqueteInicial() 
    {
        $.get("/drop/paquete/inicial", function(response) {
            $('#fkpaquete').empty();
            $('#fkpaquete').append('<option value="" selected>Seleccionar Uno</option>');

            for(i=0; i < response.length; i++)
            {
                $('#fkpaquete').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
            }                
        });
    } 
    
    function dropPaquetePersona(id) 
    {
        var puntos = 0, sub = 0, descuento = 0.25, total = 0;

        $.get("/drop/paquete/inicial/"+id.value, function(response) {
            $('#total_puntos').empty();
            $('#sub_total').empty();
            $('#descuento').empty();
            $('#total_precio').empty();
            $('#info').empty();

            for(i=0; i < response.length; i++)
            {
                $('#info').append('<tr><td>'+response[i].categoria+'/'+response[i].producto+'</td><td>'+response[i].precio+'</td><td>'+response[i].punto+'</td></tr>');
                puntos = parseFloat(response[i].punto) + puntos;
                sub = parseFloat(response[i].precio) + sub;
                id_paquete_producto = response[i].id;
            }                

            descuento = descuento * sub;
            total = sub - descuento;

            $('#total_puntos').val(puntos);
            $('#sub_total').val(sub);
            $('#descuento').val(descuento);
            $('#total_precio').val(total);            
        });
    }

    $(document).on('click', '.paquete-modal', function() {
        $('.modal-title-paquete').text('Agregar Paquete Inicial');
        $('.erroFKPaquete').addClass('hidden');
        id = $(this).data('id');
        dropPaqueteInicial();
        $('#addPaqueteModal').modal('show');
    });     

    $('.modal-footer').on('click', '.add-paquete', function() {
        if(id > 0)
        {
            $.ajax({
                type: 'POST',
                url: '/Paquete/Inicial/Persona',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fkpersona': id,
                    'fkpaquete_producto': id_paquete_producto,  
                },
                success: function(data) {
                    $('.erroFKPaquete').addClass('hidden');
    
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addPaqueteModal').modal('show');
                            swal("Error", "No se ingreso la informacion", "error", {
                              buttons: false,
                              timer: 2000,
                            });
                        }, 500);

                        if (data.errors.fkpaquete_producto) {
                            $('.erroFKPaquete').removeClass('hidden');
                            $('.erroFKPaquete').text(data.errors.fkpaquete_producto);
                        }
                                                     
                    } else {
                        swal("Correcto", "Se ingreso la informacion", "success")
                        .then((value) => {  
                            id = 0;
                            tabla.ajax.reload();
                        });                          
                    }
                },
            });
        } 
    });

    </script>
@stop