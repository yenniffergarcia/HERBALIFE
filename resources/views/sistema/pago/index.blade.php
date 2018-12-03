@extends('adminlte::page')

@section('title', 'Sistema - Pagos de Asociado')

@section('content_header')
    <div class="content-header">
        <h1>Pagos de Asociado  </h1>                    
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
                                        <th width="40%">Monto</th>
                                        <th width="40%">Mes</th>
                                        <th width="20%">Año</th>
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
            ajax: "{{ route('getdata.Pago') }}",
            columns: [
                { data: 'monto', name: 'monto' },               
                { data: 'mes', name: 'mes' }, 
                { data: 'anio', name: 'anio' },                                   
            ]
        });
    });  

    </script>
@stop