<?php

namespace Tests\Feature\acceptance\http\homecontroller;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class ContactPageTest extends AbstractHttpTestClass
{
    protected $getRoute = 'contact';

    /**
     * @group acceptance
     * @group home
     * @test
     */
    public function it_must_return_the_ecommerce_welcome_view()
    {
        $this->getResponse->assertViewIs('ecommerce.contact');
    }
}
