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
        $data->nombre = 'Chimaltenango';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Chiquimula';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Petén';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'El Progreso';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Quiché';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Escuintla';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Guatemala';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Huehuetenango';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Izabal';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Jalapa';
        $data->save(); 
        
        $data = new App\Departamento();
        $data->nombre = 'Jutiapa';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Quetzaltenango';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Retalhuleu';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Sacatepéquez';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'San Marcos';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Santa Rosa';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Sololá';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Suchitepéquez';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Totonicapán';
        $data->save();

        $data = new App\Departamento();
        $data->nombre = 'Zacapa';
        $data->save();                                        
    }
}
