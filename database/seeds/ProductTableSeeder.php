<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Product', 50)->create();
        $products = \App\Library\Data\FetchJsonFile::open('products.json');
        foreach ($products as $product)
        {
            $category = \App\Category::inRandomOrder()->first();
            $tax = \App\Tax::inRandomOrder()->first();
            $image = \App\Image::create([
               'path' => $product['image'],
               'thumbnail' => $product['thumbnail']
            ]);
            \App\Product::create([
                'title' => $product['name'],
                'image_id' => $image->id,
                'category_id' => $category->id,
                'tax_id' => $tax->id,
                'price' => $product['price'],
                'weight' => $product['weight'],
                'description' => $product['description']
            ]);
        }
    }
}
