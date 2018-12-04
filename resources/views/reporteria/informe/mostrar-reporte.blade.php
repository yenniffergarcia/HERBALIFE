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
          <h3 class="box-title">Informe del Asociado</h3>
        </div>
        <div class="box-header with-border">
            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('filtrar.informe') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-11">
                    <label for="anio">Año</label>
                    <select id="anio" class="form-control" >
                        <option value="0" selected>Seleccionar Uno</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
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
            @if(!$puntos->isEmpty())
            <div class="row pull-right">
                <button class="btn btn-warning btn-sm imprimirBtn">Imprimir</button>
            </div>
            @endif

                <div class="col-sm-6">
                    <h3>Bonificaciones</h3>
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Equipo de Expación</th>
                                    <th>Porcentaje</th>
                                    <th>Monto</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bonificaciones as $bonificacion)
                                    <tr>
                                        <td> {{ $bonificacion->nombre }} </td>
                                        <td> {{ $bonificacion->porcentaje }} </td>
                                        <td> {{ $bonificacion->monto }} </td>
                                        <td> {{ $bonificacion->mes }} </td>
                                        <td> {{ $bonificacion->anio }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>

                <div class="col-sm-6">
                    <h3>Regalias</h3>
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Porcentaje</th>
                                    <th>Monto</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($regalias as $regalia)
                                    <tr>
                                        <td> {{ $regalia->id }} </td>
                                        <td> {{ $regalia->porcentaje }} </td>
                                        <td> {{ $regalia->monto }} </td>
                                        <td> {{ $regalia->mes }} </td>
                                        <td> {{ $regalia->anio }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>                

                <div class="col-sm-6">
                    <h3>Puntos del Mes</h3>
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Monto</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($puntos as $punto)
                                    <tr>
                                        <td> {{ $punto->punto }} </td>
                                        <td> {{ $punto->mes }} </td>
                                        <td> {{ date("Y", strtotime($punto->fecha)) }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>

                <div class="col-sm-6">
                    <h3>Asociados en la Red</h3>
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre de la Persona</th>
                                    <th>Punteo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($puntos_red as $punto_red)
                                    <tr>
                                        <td> {{ $punto_red->codigo }} </td>
                                        <td> {{ $punto_red->nombre1 }} {{ $punto_red->apellido1 }} </td>
                                        <td> {{ $punto_red->red }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>                
            
        </div>
    </div>

    <script type="text/javascript">
        
        $(document).on('click', '.imprimirBtn', function() {
            
            var anio = $('#anio').val();

            let ruta_original = "{{ route('imprimir.informe', ['anio' => 'idAnio']) }}";
            var ruta_anio = ruta_original.replace('idAnio', anio);

            $.ajax({
                type: 'GET',
                url: ruta_anio,
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {   
                    window.location.replace(ruta_anio);                                                               
                }
            });         

        });  

    </script>

@stop