<?php

use Illuminate\Database\Seeder;

class DescuentoSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Descuento();
        $data->porcentaje = '2';
        $data->save();

        $data = new App\Descuento();
        $data->porcentaje = '4';
        $data->save(); 

        $data = new App\Descuento();
        $data->porcentaje = '5';
        $data->save();  
    }
}
