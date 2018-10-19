<?php

use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Review', 150)->create();
        $reviews = \App\Library\Data\FetchJsonFile::open('reviews.json');

        foreach ($reviews as $review)
        {
            $product = \App\Product::inRandomOrder()->first();
            $user = \App\User::inRandomOrder()->first();
            \App\Review::create([
               'product_id' => $product->id,
               'user_id' => $user->id,
               'stars' => $review['stars'],
               'review' => $review['review']
            ]);
        }
    }
}
