<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\ProductsTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTransformerTest extends TestCase
{
    use DatabaseMigrations, \SetUpProductsTrait;

    /**
     * @var array
     */
    protected $productsTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->productsTransformer = ProductsTransformer::single($this->products[0]);
    }

    /** @test */
    public function it_must_be_able_to_return_an_array_for_a_collection_of_addresses()
    {
        $products = ProductsTransformer::transform($this->products);
        $this->assertCount(4, $products);
    }

    /** @test */
    public function the_products_transformer_must_return_the_id()
    {
        $this->assertArrayHasKey('product_id', $this->productsTransformer);
        $this->assertEquals($this->products[0]->id, $this->productsTransformer['product_id']);
    }

    /** @test */
    public function the_products_transformer_must_return_the_price()
    {
        $this->assertArrayHasKey('price', $this->productsTransformer);
        $this->assertEquals($this->products[0]->price, $this->productsTransformer['price']);
    }

    /** @test */
    public function the_products_transformer_must_return_the_description()
    {
        $this->assertArrayHasKey('description', $this->productsTransformer);
        $this->assertEquals($this->products[0]->description, $this->productsTransformer['description']);
    }

    /** @test */
    public function the_products_transformer_must_return_the_weight()
    {
        $this->assertArrayHasKey('weight', $this->productsTransformer);
        $this->assertEquals($this->products[0]->weight, $this->productsTransformer['weight']);
    }

    /** @test */
    public function the_products_transformer_must_return_the_category()
    {
        $this->assertArrayHasKey('category', $this->productsTransformer);
        $this->assertEquals($this->products[0]->category->name, $this->productsTransformer['category']);
    }

    /** @test */
    public function the_products_transformer_must_return_the_image()
    {
        $this->assertArrayHasKey('image', $this->productsTransformer);
        $this->assertEquals($this->products[0]->image->path, $this->productsTransformer['image']);
    }
}
