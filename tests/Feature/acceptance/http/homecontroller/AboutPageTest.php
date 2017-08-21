<?php

namespace Tests\Feature\acceptance\http\homecontroller;


use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class AboutPageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'about';

    /**
     * @group acceptance
     * @group home
     * @test
     */
    public function it_must_return_the_ecommerce_welcome_view()
    {
        $this->getResponse->assertViewIs('ecommerce.about');
    }
}
