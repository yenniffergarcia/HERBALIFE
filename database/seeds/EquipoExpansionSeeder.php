<?php

use Illuminate\Database\Seeder;

class EquipoExpansionSeeder extends Seeder
{
    public function run()
    {
        $data = new App\EquipoExpansion();
        $data->nombre = 'Get Plus';
        $data->porcentaje = '0.02';
        $data->save();

        $data = new App\EquipoExpansion();
        $data->nombre = 'Millonario';
        $data->porcentaje = '0.04';
        $data->save(); 

        $data = new App\EquipoExpansion();
        $data->nombre = 'Equipo de Presidente';
        $data->porcentaje = '0.06';
        $data->save();
    }
}
