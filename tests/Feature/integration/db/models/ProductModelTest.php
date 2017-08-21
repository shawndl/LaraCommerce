<?php

namespace Tests\Feature\integration\db\models;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductModelTest extends TestCase
{
    use DatabaseMigrations, \SetUpProductsTrait;

    public function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
    }

    /** @test */
    public function it_must_be_able_to_format_a_price_to_always_have_2_digits()
    {
        $this->assertEquals(18.00, $this->getProduct('book'));
        $this->assertEquals(number_format(21.94, 2), $this->getProduct('notebook'));
        $this->assertEquals(1.00, $this->getProduct('pencil'));
        $this->assertEquals(25.99, $this->getProduct('table'));
    }

    /**
     * gets the price of a product based on the title
     *
     * @param $title
     * @return float
     */
    private function getProduct($title)
    {
        $product = Product::where('title', $title)->first();
        return $product->price;
    }
}
