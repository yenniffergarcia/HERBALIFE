<?php

Auth::routes();

//Dashboard
Route::get('/', 'HomeController@index')->name('home');


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
Route::get('/getdata/PaqueteInicial', 'PaqueteInicialController@getdata')->name('getdata.PaqueteInicial');
Route::get('/PaqueteInicial/buscar/{id}', 'PaqueteInicialController@buscar');
Route::post('/estado/PaqueteInicial', 'PaqueteInicialController@estado');

//Producto
Route::resource('/Producto', 'ProductoController');
Route::get('/getdata/Producto', 'ProductoController@getdata')->name('getdata.Producto');
Route::get('/Producto/buscar/{id}', 'ProductoController@buscar');
Route::post('/estado/Producto', 'ProductoController@estado');
Route::get('/drop/categoria', 'ProductoController@dropCategoria');

//Persona
Route::resource('/Persona', 'PersonaController');
Route::get('/Persona/Admin/Data', 'PersonaController@indexAdmin');
Route::get('/getdata/Persona', 'PersonaController@getdata')->name('getdata.Persona');
Route::get('/getdata/Persona/Admin', 'PersonaController@getdataAdmin')->name('getdata.Admin');
Route::get('/Persona/buscar/{id}', 'PersonaController@buscar');
Route::post('/estado/Persona', 'PersonaController@estado');
Route::post('/estado/Persona/Admin', 'PersonaController@estadoAdmin');
Route::get('/drop/departamento', 'PersonaController@dropDepartamento');