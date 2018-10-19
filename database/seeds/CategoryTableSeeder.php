<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    protected $categories = [
        'Women',
        'Men',
        'Kids',
        'Shoes',
        'Exercise',
        'Watches'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category)
        {
            \App\Category::create([
               'name' => $category
            ]);
        }
    }
}
