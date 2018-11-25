<?php

use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Producto();
        $data->fkcategoria = 1;
        $data->nombre = 'Formula 1 Batido Nutricional';
        $data->descripcion = 'Polvo para preparar batido nutricional con proteína de soya, fibra, vitaminas y minerales. Sabor: Vainilla';
        $data->punto = 23.95;
        $data->precio = 35;       
        $data->save();
    }
}
