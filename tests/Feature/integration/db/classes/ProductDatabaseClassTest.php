<?php

namespace Tests\Feature\integration\db\classes;

use App\Library\Database\ProductDatabase;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductDatabaseClassTest extends TestCase
{
    use \SetUpTaxTrait, \SetUpCategoryTrait, \SetUpImageTrait, DatabaseMigrations;

    protected $product = [
        'title' => 'I-Phone',
        'description' => 'a phone',
        'price' => 1299.99,
        'weight' => 1.32
    ];

    /**
     * @var Product
     */
    protected $productModel;

    public function setUp()
    {
        parent::setUp();
        $this->setUpCategory();
        $this->setUpTax();
        $this->setUpImage();
        $this->product['category'] = $this->category->id;
        $this->product['tax'] = $this->tax->id;
        $this->productModel = ProductDatabase::create(new Product(), $this->image->id, $this->product);
    }

    /** @test */
    public function it_must_be_able_to_create_a_new_product()
    {
        $this->assertDatabaseHas('products', [
            'title' => 'I-Phone'
        ]);
        $this->assertEquals(1, Product::count());
    }
    
    /** @test */
    public function it_must_return_the_product_created()
    {
        $this->assertInstanceOf(Product::class, $this->productModel);
    }
    
    /** @test */
    public function it_must_be_able_to_update_a_product()
    {
        $productModel = $this->updateProduct();
        $this->assertEquals('Samsung', $productModel->title);
    }

    /** @test */
    public function it_must_return_the_updated_product()
    {
        $productModel = $this->updateProduct();
        $this->assertInstanceOf(Product::class, $productModel);
    }

    /**
     * updates the product and changes title to Samsung
     *
     * @return Product
     */
    private function updateProduct()
    {
        $product = [
            'title' => 'Samsung',
            'description' => 'a phone',
            'price' => 1299.99,
            'weight' => 1.32
        ];
        $product['category'] = $this->category->id;
        $product['tax'] = $this->tax->id;
        return ProductDatabase::update($this->productModel, $this->image->id, $product);
    }
}
