<?php

use Illuminate\Database\Seeder;

class PaqueteInicialSeeder extends Seeder
{
    public function run()
    {
        $data = new App\PaqueteInicial();
        $data->nombre = 'Paquete No. 1';
        $data->save();

        $data = new App\PaqueteInicial();
        $data->nombre = 'Paquete No. 2';
        $data->save(); 
    }
}
