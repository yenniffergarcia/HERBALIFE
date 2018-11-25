<?php

use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    public function run()
    {
        $data = new App\Mes();
        $data->mes = 'Enero';
        $data->save();

        $data = new App\Mes();
        $data->mes = 'Febrero';
        $data->save(); 

        $data = new App\Mes();
        $data->mes = 'Marzo';
        $data->save();
        
        $data = new App\Mes();
        $data->mes = 'Abril';
        $data->save();

        $data = new App\Mes();
        $data->mes = 'Mayo';
        $data->save(); 

        $data = new App\Mes();
        $data->mes = 'Junio';
        $data->save(); 
        
        $data = new App\Mes();
        $data->mes = 'Julio';
        $data->save();

        $data = new App\Mes();
        $data->mes = 'Agosto';
        $data->save(); 

        $data = new App\Mes();
        $data->mes = 'Septiembre';
        $data->save();
        
        $data = new App\Mes();
        $data->mes = 'Octubre';
        $data->save();

        $data = new App\Mes();
        $data->mes = 'Noviembre';
        $data->save(); 

        $data = new App\Mes();
        $data->mes = 'Diciembre';
        $data->save();           
    }
}
