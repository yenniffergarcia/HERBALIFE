<?php

use Illuminate\Database\Seeder;

class NivelSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Nivel();
        $data->nombre = 'Asociado Independiente';
        $data->fkdescuento = 1;
        $data->save();

        $data = new App\Nivel();
        $data->nombre = 'Constructor del Exito';
        $data->fkdescuento = 2;
        $data->save(); 
    }
}
