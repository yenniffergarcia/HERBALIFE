@extends('adminlte::page')

@section('title', 'HERBALIFE')

@section('content_header')
	<h1>Dashboard</h1>
@stop

@section('content')

	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
            	<h3>{{ count($regalias) }}</h3>
            	<p>Regalias</p>
            </div>
            <div class="icon">
              <i class="fa fa-gift"></i>
            </div>
            <a href="{{ route('Regalia.index') }}" class="small-box-footer">Ver más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
                @if(!$boficaciones->isEmpty())
	            	@foreach($boficaciones as $boficacion)
	            		<h3>{{ $boficacion->porcentaje }}<sup style="font-size: 20px">%</sup></h3>
	            	@endforeach
                @else
                  <h3>0<sup style="font-size: 20px">%</sup></h3>                                  
                @endif 
            	<p>Bonificación Actual</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="{{ route('Bonificacion.index') }}" class="small-box-footer">Ver más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($redes) }}</h3>
              <p>Asociados en Red</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('Persona.index') }}" class="small-box-footer">Ver más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ count($pagos) }}</h3>
              <p>Pagos Obtenidos</p>
            </div>
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <a href="{{ route('Pago.index') }}" class="small-box-footer">Ver más información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    </div>

	<div class="row">
		<div class="col-sm-6">
			<div id="graficaNivel" style="min-width: auto; height: 250px; margin: 0 auto"></div>
		</div>
		<div class="col-sm-6">
			<div id="graficaPunteoAsociado" style="min-width: auto; height: 250px; margin: 0 auto"></div>
		</div>		
	</div>

	<br>

	<div class="row">
        <div class="col-md-12">
          	<div class="box">
            	<div class="box-header with-border">
              		<h3 class="box-title">Información Anual</h3>
            	</div>

	            <div class="box-body">
	            	<div class="row">
	                	<div class="col-md-8">
	                  		<p class="text-center">
	                    		<strong>{{ date('d-m-Y h:m:s') }}</strong>
	                  		</p>

				            <div class="table-responsive">
				                <table class="table no-margin">
					                <thead>
						                <tr>
							                <th>Código</th>
							                <th>Puntos 1 Mes</th>
							                <th>Puntos 2 Meses</th>
							                <th>Puntos 12 Meses</th>
						                </tr>
					                </thead>
					                <tbody>
					                	@foreach($redes as $red)
						                <tr>
							                <td><a href="#">{{ $red->codigo }}</a></td>
							                <td>{{ $red->punteo_mes }}</td>
											<td>{{ $red->punteo_dos_meses }}</td>
											<td>{{ $red->punteo_doce_meses }}</td> 
						                </tr>
						                @endforeach
					                </tbody>
				                </table>
				            </div>

	                	</div>

	                	<div class="col-md-4">
			                <p class="text-center">
			                	<strong>Punteo por Nivel</strong>
			                </p>

			                <div class="progress-group">
			                    <span class="progress-text">Consultor Mayor</span>
			                    @foreach($puntos as $punto)
				                    <span class="progress-number"><b>{{ $punto->punteo_mes }}</b>/500</span>
				                    <div class="progress sm">
				                      <div class="progress-bar progress-bar-aqua" style="width: {{ ($punto->punteo_mes/500)*100 }}%"></div>
				                    </div>
			                    @endforeach
			                </div>
	                  
			                <div class="progress-group">
			                    <span class="progress-text">Constructor del Exito</span>
			                    @foreach($puntos as $punto)
				                    <span class="progress-number"><b>{{ $punto->punteo_dos_meses }}</b>/2500</span>
				                    <div class="progress sm">
				                      <div class="progress-bar progress-bar-red" style="width: {{ ($punto->punteo_dos_meses/2500)*100 }}%"></div>
				                    </div>
			                    @endforeach
			                </div>

			                <div class="progress-group">
			                    <span class="progress-text">Mayorista</span>
			                    @foreach($puntos as $punto)
				                    <span class="progress-number"><b>{{ $punto->punteo_doce_meses }}</b>/4000</span>
				                    <div class="progress sm">
				                      <div class="progress-bar progress-bar-green" style="width: {{ ($punto->punteo_doce_meses/4000)*100 }}%"></div>
				                    </div>
			                    @endforeach
			                </div>

	                	</div>
	              	</div>
	            </div>

	            <div class="box-footer">
	            	@foreach($informacion_pagos as $informacion)
		            	<div class="row">
		            		<div class="col-sm-12" style="text-align: center;">
		            			<h3>Información Anual - <b>{{ date('Y') }}</b></h3>
		            			<h4>{{ $informacion->codigo }} - {{ $informacion->nombre1 }} {{ $informacion->apellido1 }}</h4>
		            		</div>
		            	</div>
		                <div class="row">
		                	<div class="col-sm-3 col-xs-6">
		                		<div class="description-block border-right">
			                		<h5 class="description-header">Q {{ $informacion->bonificacion }}</h5>
			                		<span class="description-text">TOTAL BONIFICACIONES</span>
		                		</div>
		                	</div>

			                <div class="col-sm-3 col-xs-6">
			                	<div class="description-block border-right">
				                    <h5 class="description-header">Q {{ $informacion->regalia }}</h5>
				                    <span class="description-text">TOTAL REGALIAS</span>
			                	</div>
			                </div>

			                <div class="col-sm-3 col-xs-6">
			                	<div class="description-block border-right">
				                    <h5 class="description-header">Q {{ $informacion->descuento }}</h5>
				                    <span class="description-text">TOTAL DESCUENTOS</span>
			                	</div>
			                </div>

			                <div class="col-sm-3 col-xs-6">
				                <div class="description-block">
				                    <h5 class="description-header">Pts. {{ $informacion->red }}</h5>
				                    <span class="description-text">PUNTOS DE LA RED</span>
				                </div>
			                </div>
		              	</div>
		            @endforeach
	            </div>
        	</div>
        </div>
    </div>


	<div class="row">
		
		<div class="col-xs-8">
			
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Pedidos Recibidos</h3>
	            </div>

	            <div class="box-body">
		            <div class="table-responsive">
		                <table class="table no-margin">
			                <thead>
				                <tr>
					                <th>Pedido #</th>
					                <th>¿Quien realizo el Pedido?</th>
					                <th>Sub Total</th>
					                <th>Total</th>
					                <th>Pedido</th>
				                </tr>
			                </thead>
			                <tbody>
			                	@foreach($pedidos as $pedido)
				                <tr>
					                <td><a href="#">{{ $pedido->id }}</a></td>
					                <td>{{ $pedido->codigo }} - {{ $pedido->nombre1 }} {{ $pedido->apellido1 }}</td>
									<td>{{ $pedido->subtotal }}</td>
									<td>{{ $pedido->total }}</td>
									@if($pedido->pagado == 1)
										<td><span class="label label-success">Pagado</span></td>
									@else
										<td><span class="label label-danger">No Pagado</span></td>
									@endif  
				                </tr>
				                @endforeach
			                </tbody>
		                </table>
		            </div>
	            </div>
	            <div class="box-footer clearfix">
	            	<a href="{{ route('Pedido.index') }}" class="btn btn-sm btn-default btn-flat pull-right">Ver todos los pedidos...</a>
	            </div>
	        </div>

		</div>

	<div class="col-xs-4">
			
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Stock</h3>
	            </div>

	            <div class="box-body">
		            <div class="table-responsive">
		                <table class="table no-margin">
			                <thead>
				                <tr>
					                <th>Cantidad</th>
					                <th>Producto</th>
					                <th>Precio</th>
				                </tr>
			                </thead>
			                <tbody>
			                	@foreach($stocks as $stock)
				                <tr>
					                <td>{{ $stock->cantidad }}</td>
					                <td>{{ $stock->nombre }} - {{ $stock->punto }}</td>
					                <td>{{ $stock->precio }}</td>
				                </tr>
				                @endforeach
			                </tbody>
		                </table>
		            </div>
	            </div>
	            <div class="box-footer clearfix">
	            	<a href="{{ route('Stock.index') }}" class="btn btn-sm btn-default btn-flat pull-right">Ver todos los pedidos...</a>
	            </div>
	        </div>

		</div>		

	</div>

	<script>
		
    $(function () {
     
        //on page load  
        getJSONGraficaNivel();
        getJSONGraficaPunteoAsociado();
     
        function getJSONGraficaNivel()
        {
	        $.getJSON('/grafica/nivel', function(chartData) 
	        {
	          Highcharts.chart('graficaNivel', {
	            chart: {
	              plotBackgroundColor: null,
	              plotBorderWidth: null,
	              plotShadow: false,
	              type: 'pie'
	            },
	            title: {
	              text: 'Asociados por Nivel'
	            },
	            tooltip: {
	              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	            },
	            plotOptions: {
	              pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                  enabled: true,
	                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                  style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                  }
	                }
	              }
	            },
	            series: [{
	              name: 'Porcentaje',
	              colorByPoint: true,
	              data: chartData   
	            }]
	          });
	        });
      	}

        function getJSONGraficaPunteoAsociado()
        {
	        $.getJSON('/grafica/punteo/asociado', function(chartData) 
	        {
	          Highcharts.chart('graficaPunteoAsociado', {
	            chart: {
	              plotBackgroundColor: null,
	              plotBorderWidth: null,
	              plotShadow: false,
	              type: 'pie'
	            },
	            title: {
	              text: 'Punteo de Asociados de la Red'
	            },
	            tooltip: {
	              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	            },
	            plotOptions: {
	              pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                  enabled: true,
	                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                  style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                  }
	                }
	              }
	            },
	            series: [{
	              name: 'Porcentaje',
	              colorByPoint: true,
	              data: chartData   
	            }]
	          });
	        });
      	}      	
    });		

	</script>

@stop