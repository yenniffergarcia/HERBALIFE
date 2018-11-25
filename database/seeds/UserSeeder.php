<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {   
        $data = new App\User();
        $data->username = 'administrador';
        $data->email = 'admin@gmail.com';
        $data->fkpersona = 1;
        $data->password = bcrypt('admin1234');
        $data->save();
    }
}
