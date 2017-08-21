<?php
/*
|--------------------------------------------------------------------------
| DiscoverCardFailTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent a user from using a discover card
|    As a user
|    I need pay pay with a discover card
|
| Scenario:
|   Given: I entered my visa card number
|   And: All the information is correct
|   When: I submit my card information
|   Then: I should receive an error message
|   And:  No stripe token should be created
*/
namespace Tests\Feature\acceptance\http\order\payment\failed;


use Tests\Feature\acceptance\http\order\payment\AbstractPayment;

class DiscoverCardFailTest extends AbstractPayment
{
    //Please read the comments above for details about the test
    protected $cardResponse = 'discover';

    protected $paidFor = 0;

    /** @test
     *  @group live_payment
     */
    public function the_payment_must_provide_the_correct_response()
    {
        $this->assertEquals('Your card is not supported.', $this->stripeError);
        $this->assertNull($this->token);
    }
}
