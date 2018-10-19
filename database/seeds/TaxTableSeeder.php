<?php

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Tax', 10)->create();
        $taxes = \App\Library\Data\FetchJsonFile::open('taxes.json');
        foreach ($taxes as $tax)
        {
            \App\Tax::create([
               'name' => $tax['name'],
               'description' => $tax['description'],
               'percent' => $tax['percent']
            ]);
        }
    }
}
