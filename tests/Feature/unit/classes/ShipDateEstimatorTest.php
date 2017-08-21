<?php

namespace Tests\Feature\unit\classes;

use App\Library\Order\ShippingDateEstimator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShipDateEstimatorTest extends TestCase
{
    /** @test */
    public function it_must_be_able_to_return_a_date_in_the_future_based_on_the_number_of_days_parameter()
    {
        $this->assertEquals('Jun 3rd, 2017',
            ShippingDateEstimator::arrivalDate(new \DateTime('01-06-2017'), 2));
        $this->assertEquals('Jun 5th, 2017',
            ShippingDateEstimator::arrivalDate(new \DateTime('01-06-2017'), 4));
        $this->assertEquals('Jun 11th, 2017',
            ShippingDateEstimator::arrivalDate(new \DateTime('01-06-2017'), 10));
    }


}
