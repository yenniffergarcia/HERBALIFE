<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $data = new Categoria;
        $data->nombre = 'Nutricion';
        $data->save();       
    }
}
