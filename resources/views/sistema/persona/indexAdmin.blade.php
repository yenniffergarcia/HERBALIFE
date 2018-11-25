@extends('adminlte::page')

@section('title', 'Mantenimiento - Persona')

@section('content_header')
    <div class="content-header">
        <h1>Persona</h1>                    
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
                                        <th width="25%">Persona</th>
                                        <th width="15%">Residencia</th>
                                        <th width="10%">Email</th>
                                        <th width="10%">Usuario</th>
                                        <th width="25%">Red</th>
                                        <th width="8%">Opciones</th>
                                    </tr>
                                </thead>
                            </table> 
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
            ajax: "{{ route('getdata.Admin') }}",
            columns: [
                { data: 'codigo', name: 'codigo' },  
                { data: 'persona', name: 'persona' },   
                { data: 'residencia', name: 'residencia' }, 
                { data: 'email', name: 'email' }, 
                { data: 'username', name: 'username' },  
                { data: 'cargo', name: 'cargo' },                                  
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });  

    $(document).on('click', '.alta-modal', function() {
        $.ajax({
            type: 'POST',
            url: '/estado/Persona/Admin',
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