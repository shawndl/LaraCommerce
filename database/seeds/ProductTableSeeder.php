<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    protected $images = [
        [
            'main' => 'accessory-analog-classic.jpg',
            'theme' => 'accessory-analog-classic_tn.jpg'
        ],
        [
            'main' => 'accessory-classic-close-up.jpg',
            'theme' => 'accessory-classic-close-up_tn.jpg'
        ],
        [
            'main' => 'analog-watch-black-and-white-reflection.jpg',
            'theme' => 'analog-watch-black-and-white-reflection_tn.jpg'
        ],
        [
            'main' => 'analogue-color-executive.jpg',
            'theme' => 'analogue-color-executive_tn.jpg'
        ],
        [
            'main' => 'background-bright-close-up.jpg',
            'theme' => 'background-bright-close-up_tn.jpg'
        ],
        [
            'main' => 'black-and-white-coach-design.jpg',
            'theme' => 'black-and-white-coach-design_tn.jpg'
        ],
        [
            'main' => 'black-camera-dslr.jpg',
            'theme' => 'black-camera-dslr_tn.jpg'
        ],
        [
            'main' => 'black-classic-clothes.jpg',
            'theme' => 'black-classic-clothes_tn.jpg'
        ],
        [
            'main' => 'blur-blurred-background-bottle.jpg',
            'theme' => 'blur-blurred-background-bottle_tn.jpg'
        ],
        [
            'main' => 'blur-brush-close-up.jpg',
            'theme' => 'blur-brush-close-up_tn.jpg'
        ],
        [
            'main' => 'blur-business-close-up.jpg',
            'theme' => 'blur-business-close-up_tn.jpg'
        ],
        [
            'main' => 'blurred-background-book-shelves-books.jpg',
            'theme' => 'blurred-background-book-shelves-books_tn.jpg'
        ],
        [
            'main' => 'bottle-container-glass.jpg',
            'theme' => 'bottle-container-glass_tn.jpg'
        ],
        [
            'main' => 'camera-digicam-digital-camera.jpg',
            'theme' => 'camera-digicam-digital-camera_tn.jpg'
        ],
        [
            'main' => 'camera-dslr-electronics.jpg',
            'theme' => 'camera-dslr-electronics_tn.jpg'
        ],
        [
            'main' => 'fashion-footwear-shoes.jpg',
            'theme' => 'fashion-footwear-shoes_tn.jpg'
        ],
        [
            'main' => 'footwear-shoe-sneakers.jpg',
            'theme' => 'footwear-shoe-sneakers_tn.jpg'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Product', 50)->create();
        $products = \App\Library\Data\FetchJsonFile::open('products.json');
        $paths = $this->images;
        foreach ($products as $product)
        {
            if(count($paths) > 0) {
                $path = array_pop($paths);
            } else {
                $paths = $this->images;
                $path = array_pop($paths);
            }
            $category = \App\Category::inRandomOrder()->first();
            $tax = \App\Tax::inRandomOrder()->first();
            $image = \App\Image::create([
               'path' => '/images/products/' . $path['main'],
               'thumbnail' => '/images/products/' . $path['theme']
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
