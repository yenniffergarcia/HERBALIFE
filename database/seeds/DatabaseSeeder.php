<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolSeeder::class);       
        $this->call(CategoriaSeeder::class);
        $this->call(CompaniaSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(DescuentoSeeder::class);
        $this->call(MesSeeder::class);
        $this->call(NivelSeeder::class);  
        $this->call(PaqueteInicialSeeder::class);
        $this->call(ProductoSeeder::class);          
        $this->call(PersonaSeeder::class);                                 
    }
}
