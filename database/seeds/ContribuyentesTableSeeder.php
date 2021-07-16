<?php

use Illuminate\Database\Seeder;

class ContribuyentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Contribuyente::class, 50)->create()->each(function($contribuyente) {
            $contribuyente->save();
        });
    }
}