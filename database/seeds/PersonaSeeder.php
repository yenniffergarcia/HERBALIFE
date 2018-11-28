<?php

use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Persona();
        $data->nombre1 = 'Yennifer';
        $data->nombre2 = '';
        $data->apellido1 = 'Garcia';
        $data->apellido2 = 'Taracena';
        $data->apellido3 = '';
        $data->direccion = 'Chiquimulilla';
        $data->id_padre = 0;
        $data->email = 'admin@gmail.com';
        $data->codigo = 'HER-0000001';
        $data->fkdepartamento = 3;
        $data->save();
    }
}
