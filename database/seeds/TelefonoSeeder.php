<?php

use Illuminate\Database\Seeder;

class TelefonoSeeder extends Seeder
{	
    public function run()
    {
        $data = new App\Telefono();
        $data->fkpersona = 1;
        $data->fkcompania = 2;
        $data->numero = '45676545';
        $data->save();
    }
}
