<?php

use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Rol();
        $data->nombre = 'Administrador';
        $data->save();

        $data = new App\Rol();
        $data->nombre = 'Gerente';
        $data->save(); 
        
        $data = new App\Rol();
        $data->nombre = 'Asociado';
        $data->save();          
    }
}
