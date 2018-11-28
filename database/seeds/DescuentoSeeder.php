<?php

use Illuminate\Database\Seeder;

class DescuentoSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Descuento();
        $data->porcentaje = '0.25';
        $data->save();

        $data = new App\Descuento();
        $data->porcentaje = '0.35';
        $data->save(); 

        $data = new App\Descuento();
        $data->porcentaje = '0.42';
        $data->save();
        
        $data = new App\Descuento();
        $data->porcentaje = '0.50';
        $data->save();          
    }
}
