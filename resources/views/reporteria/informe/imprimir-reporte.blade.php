<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'> 
    <style>
        #divPrincipal{
            width: 99%; align-items: center; align-content: center; align-self: center;
        }
        #divLogo{
            align-content: center; align-items: center;  text-align: center;
        }
        #divDerecha{
            text-align: right;
        }
        #divInstruccion{
            border: 1px solid; border: 2px solid red; padding: 10px; border-radius: 25px; color: black;
        }
        #divTitulo{
            text-align: center;
        }
        #pInstruccion{
            margin-left: 20px; margin-right: 20px; color: black;
        }
        #label30{
            font-size: 30px;
        }
        #label40{
            font-size: 40px;
        }        
        #label12{
            font-size: 12px;
        }
        #tableContenido{
            width: 100%; border-collapse: collapse; padding: 15px;
        }
        #pEstadistica{
            text-align: right;
        }
		.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Geneva, Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 2px solid #269939; -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #529902), color-stop(1, #697F2E) );background:-moz-linear-gradient( center top, #529902 5%, #697F2E 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#529902', endColorstr='#697F2E');background-color:#529902; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #53A82F; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #000000; border-left: 1px solid #6BF4D4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #DBFFD4; color: #000000; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #269939;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }
        #tablaEstadistica{
            style='width: 100%;'
        }
     </style>

</head>
<body>

	<header>
		<img src='img/header-left.png' width="100%">
	</header>
	<br><br>
    <div id="divPrincipal">
        <div id="divLogo">
            <img src='img/herbalife.jpg' height='100px'>
            <br>
            <label id="label12"><b>{{ date('d/m/Y h:i:s') }}</b></label>
        </div>     
        <br>
    </div>

    <br><br>
    <div>
        <hr>

            <table width="100%">
                <tr>
                    <td width="100px">
                        <label id="label12"><b>Bonificaciones</b></label>
                        <table class="datagrid" style="width: 100%">
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
                    </td>

                    <td width="100px">
                        <label id="label12"><b>Regalias</b></label>
                        <table class="datagrid" style="width: 100%">
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
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td width="300px">
                        <label id="label12"><b>Puntos del Mes</b></label>
                        <table class="datagrid" style="width: 100%">
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
                    </td>

                    <td width="416px">
                        <label id="label12"><b>Asociados en la Red</b></label>
                        <table class="datagrid" style="width: 100%">
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
                    </td>
                </tr>
            </table>            

        <hr>
    </div>
</body>
</html>
