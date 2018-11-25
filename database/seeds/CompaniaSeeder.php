<?php

use Illuminate\Database\Seeder;

class CompaniaSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Compania;
        $data->nombre = 'Claro';
        $data->save();

        $data = new App\Compania;
        $data->nombre = 'Tigo';
        $data->save(); 

        $data = new App\Compania;
        $data->nombre = 'Movistar';
        $data->save();         
    }
}
