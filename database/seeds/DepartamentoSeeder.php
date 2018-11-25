<?php

use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Departamento();
        $data->nombre = 'Alta Verapaz';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Baja Verapaz';
        $data->save(); 

        $data = new App\Departamento();
        $data->nombre = 'Santa Rosa';
        $data->save();  
    }
}
