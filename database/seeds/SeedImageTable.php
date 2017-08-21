<?php

use Illuminate\Database\Seeder;

class SeedImageTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Image', 20)->create();
    }
}
