<?php

Auth::routes();

//Dashboard
Route::get('/', 'HomeController@index')->name('home');
Route::get('/Punteo', 'HomeController@indexPuntos')->name('Punteo.index');
Route::get('/Pago', 'HomeController@indexPago')->name('Pago.index');
Route::get('/Regalia', 'HomeController@indexRegalia')->name('Regalia.index');
Route::get('/Bonificacion', 'HomeController@indexBonificacion')->name('Bonificacion.index');
Route::get('/getdata/Punteo', 'HomeController@getdataPuntos')->name('getdata.Punteo');
Route::get('/getdata/Pago', 'HomeController@getdataPago')->name('getdata.Pago');
Route::get('/getdata/Regalia', 'HomeController@getdataRegalia')->name('getdata.Regalia');
Route::get('/getdata/Bonificacion', 'HomeController@getdataBonificacion')->name('getdata.Bonificacion');
Route::get('/grafica/nivel', 'HomeController@mostrarGraficaNivel');
Route::get('/grafica/punteo/asociado', 'HomeController@mostrarGraficaPunteoAsociado');

//Categoria
Route::resource('/Categoria', 'CategoriaController');
Route::get('/getdata/Categoria', 'CategoriaController@getdata')->name('getdata.Categoria');
Route::get('/Categoria/buscar/{id}', 'CategoriaController@buscar');
Route::post('/estado/Categoria', 'CategoriaController@estado');

//Descuento
Route::resource('/Descuento', 'DescuentoController');
Route::get('/getdata/Descuento', 'DescuentoController@getdata')->name('getdata.Descuento');
Route::get('/Descuento/buscar/{id}', 'DescuentoController@buscar');

//Producto
Route::resource('/Nivel', 'NivelController');
Route::get('/getdata/Nivel', 'NivelController@getdata')->name('getdata.Nivel');
Route::get('/Nivel/buscar/{id}', 'NivelController@buscar');
Route::post('/estado/Nivel', 'NivelController@estado');
Route::get('/drop/descuento', 'NivelController@dropDescuento');

//PaqueteInicial
Route::resource('/PaqueteInicial', 'PaqueteInicialController');
Route::post('/PaqueteProducto', 'PaqueteInicialController@storeProducto');
Route::get('/getdata/PaqueteInicial', 'PaqueteInicialController@getdata')->name('getdata.PaqueteInicial');
Route::get('/getdata/PaqueteInicial/Producto/{paquete}', 'PaqueteInicialController@getdataproducto')->name('getdata.PaqueteProducto');
Route::get('/PaqueteInicial/buscar/{id}', 'PaqueteInicialController@buscar');
Route::post('/estado/PaqueteInicial', 'PaqueteInicialController@estado');
Route::post('/estado/PaqueteProducto', 'PaqueteInicialController@estadoProducto');

//Producto
Route::resource('/Producto', 'ProductoController');
Route::get('/getdata/Producto', 'ProductoController@getdata')->name('getdata.Producto');
Route::get('/Producto/buscar/{id}', 'ProductoController@buscar');
Route::post('/estado/Producto', 'ProductoController@estado');
Route::get('/drop/categoria', 'ProductoController@dropCategoria');

//Persona
Route::resource('/Persona', 'PersonaController');
Route::get('/Persona/Admin/Data', 'PersonaController@indexAdmin');
Route::post('/Paquete/Inicial/Persona', 'PersonaController@storePaquetePersona');
Route::post('/Agregar/Telefono/Persona', 'PersonaController@storeTelefono');
Route::get('/getdata/Persona', 'PersonaController@getdata')->name('getdata.Persona');
Route::get('/getdata/Persona/Admin', 'PersonaController@getdataAdmin')->name('getdata.Admin');
Route::get('/getdata/Telefono/{persona}', 'PersonaController@getdataTelefono')->name('getdataTelefono.Persona');
Route::get('/Persona/buscar/{id}', 'PersonaController@buscar');
Route::post('/estado/Persona', 'PersonaController@estado');
Route::post('/estado/Persona/Admin', 'PersonaController@estadoAdmin');
Route::post('/eliminar/Telefono/Persona', 'PersonaController@eliminarTelefono');
Route::get('/drop/departamento', 'PersonaController@dropDepartamento');
Route::get('/drop/compania', 'PersonaController@dropCompania');
Route::get('/drop/paquete/inicial', 'PersonaController@dropPaqueteIncial');
Route::get('/drop/paquete/inicial/{paquete}', 'PersonaController@dropPaqueteProducto');

//DetalleCarga
Route::resource('/DetalleCarga', 'DetalleCargaController');
Route::get('/getdata/DetalleCarga', 'DetalleCargaController@getdata')->name('getdata.DetalleCarga');
Route::get('/DetalleCarga/buscar/{id}', 'DetalleCargaController@buscar');
Route::post('/estado/DetalleCarga', 'DetalleCargaController@estado');
Route::get('/drop/producto/{categoria}', 'DetalleCargaController@dropProducto');

//Pedido
Route::resource('/Pedido', 'PedidoController');
Route::get('/Pedido/Recibido/Data', 'PedidoController@indexRecibidos');
Route::get('/getdata/Pedido', 'PedidoController@getdata')->name('getdata.Pedido');
Route::get('/getpedido/Pedido', 'PedidoController@getpedido')->name('getpedido.Pedido');
Route::get('/Pedido/buscar/{id}', 'PedidoController@buscar');
Route::post('/pagado/Pedido', 'PedidoController@pagado');
Route::post('/estado/Pedido', 'PedidoController@estado');

//DetalleVenta
Route::resource('/DetalleVenta', 'DetalleVentaController');
Route::post('/storeAprobado/DetalleVenta', 'DetalleVentaController@storeAprobado');
Route::get('/getdata/DetalleVenta/{pedido}', 'DetalleVentaController@getdata')->name('getdata.DetalleVenta');
Route::get('/getdata/Historico/DetalleVenta/{pedido}', 'DetalleVentaController@getdataHistorico')->name('getdataHistorico.DetalleVenta');
Route::get('/getpedido/DetalleVenta/{pedido}', 'DetalleVentaController@getpedido')->name('getpedido.DetalleVenta');
Route::get('/getaceptado/DetalleVenta/{pedido}', 'DetalleVentaController@getaceptado')->name('getaceptado.DetalleVenta');
Route::post('/estado/DetalleVenta', 'DetalleVentaController@estado');
Route::get('/drop/stock/producto/{categoria}', 'DetalleVentaController@dropStock');
Route::get('/verificar/producto/detalle/{stock}/{pedido}', 'DetalleVentaController@verificarProductoDetalle');
Route::get('/verificar/stock/producto/{stock}/{cantidad}', 'DetalleVentaController@dropVerficiarStock');

//Stock
Route::resource('/Stock', 'StockController');
Route::get('/getdata/Stock', 'StockController@getdata')->name('getdata.Stock');

//Usuario
Route::resource('/Usuario', 'UsuarioController');
Route::get('/getdata/Usuario', 'UsuarioController@getdata')->name('getdata.Usuario');