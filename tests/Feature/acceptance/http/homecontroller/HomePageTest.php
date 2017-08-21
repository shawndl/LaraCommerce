<?php

namespace Tests\Feature\acceptance\http\homecontroller;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class HomePageTest extends AbstractHttpTestClass
{
    /**
     * @group acceptance
     * @group home
     * @test
     */
    public function the_home_page_must_have_a_products_variable()
    {
        $this->getResponse->assertViewHas('products');
    }

    /**
     * @group acceptance
     * @group home
     * @test
     */
    public function it_must_return_the_ecommerce_welcome_view()
    {
        $this->getResponse->assertViewIs('ecommerce.welcome');
    }

    /**
     * @group acceptance
     * @group home
     * @test
     */
    public function the_products_variable_must_be_an_instance_of_an_eloquent_collection()
    {
        $products = $this->getResponse->original->getData()['products'];
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $products);
    }
}
