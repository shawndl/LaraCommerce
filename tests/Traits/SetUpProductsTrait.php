<?php
use App\Product;

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 10/8/17
 * Time: 10:39 AM
 */
trait SetUpProductsTrait
{
    use SetUpCategoryTrait, SetUpTaxTrait, SetUpImageTrait;

    protected $productDetails = [
        [
            'title' => 'book',
            'description' => 'A cool book',
            'price' => 18,
            'weight' => 14.29,
        ],
        [
            'title' => 'notebook',
            'description' => 'Another cool book',
            'price' => 21.939202,
            'weight' => 13.29,
        ],
        [
            'title' => 'pencil',
            'description' => 'a pencil',
            'price' => 1.00,
            'weight' => .30,
        ],
        [
            'title' => 'table',
            'description' => 'a table',
            'price' => 25.99,
            'weight' => 39.30,
        ],

    ];

    protected $moreProducts = [
        [
            'title' => 'New Stuff',
            'description' => 'a type of thing',
            'price' => 1.00,
            'weight' => .30,
        ],
        [
            'title' => 'wood table',
            'description' => 'a table that is wooden',
            'price' => 25.99,
            'weight' => 39.30,
        ],
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $products;

    public function setUpProduct()
    {
        $this->resetProducts();
        $this->setUpCategory();
        $this->setUpImage();
        $this->setUpTax();

        foreach ($this->productDetails as $product)
        {
            \App\Product::create([
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'weight' => $product['weight'],
                'tax_id' => $this->tax->id,
                'image_id' => $this->image->id,
                'category_id' => $this->category->id
            ]);
        }
        $this->products = \App\Product::all();
    }

    /**
     *  Add more products with a second category
     *
     *  @return void
     */
    public function addMoreProducts()
    {
        $this->addCategories();
        foreach ($this->productDetails as $product)
        {
            \App\Product::create([
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'weight' => $product['weight'],
                'tax_id' => $this->tax->id,
                'image_id' => $this->image->id,
                'category_id' => $this->categories[1]->id
            ]);
        }
        $this->products = \App\Product::all();
    }

    /**
     * searches the products database
     *
     * @param $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProducts($search)
    {
        return Product::search($search)->paginate(9);
    }

    private function resetProducts()
    {
        Product::truncate();
        \App\Category::truncate();
        \App\Tax::truncate();
        \App\Image::truncate();
    }
}