@extends('adminlte::page')

@section('title', 'IMEDCHI')

@section('maps')
	<script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}
@stop

@section('content_header')
	@if($logueado->fkgenero == 1)
    	<h1>Bienvenido, {{$logueado->nombre1}} {{$logueado->nombre2}} {{$logueado->apellido1}} {{$logueado->apellido2}}</h1>
    @else
    	<h1>Bienvenida, {{$logueado->nombre1}} {{$logueado->nombre2}} {{$logueado->apellido1}} {{$logueado->apellido2}}</h1>
    @endif
@stop

@section('content')
	<div class="row"  style="text-align: center;">
		<div class="col-xs-12">
			<img src="{{ asset('img/imedchi.jpg') }}" height='100%'> <br>
			<h2><b>Instituto Diversificado por Cooperativa de Enseñanza de Chiquimulilla, Santa Rosa IMEDCHI</b></h2>
        </div>		
		<div class="col-xs-6">
			<h2><b>Misión</b></h2>
		    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
				{{$mision}}
		    </p>
        </div>	
		<div class="col-xs-6">
			<h2><b>Visón</b></h2>
		    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
				{{$vision}}
		    </p>
        </div>
        <div class="col-xs-12">
        	{!!$map['html']!!}
        </div>        	
	</div>
@stop