<?php
/*
|--------------------------------------------------------------------------
| CardProcessingErrorTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to understand why an order faild
|    As a user
|    I paid but there was a processing error
|
| Scenario:
|   Given: I entered my visa card number
|   And: All the information is correct
|   When: I submit my card information
|   Then: I should receive an error message
|   And:  The order should not be updated to paid for
*/
namespace Tests\Feature\acceptance\http\order\payment\failed;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardProcessingErrorTest extends AbstractPaymentFailure
{
    //Please read the comments above for details about the test
    protected $cardResponse = 'processError';

    protected $message = 'An error occurred while processing your card. Try again in a little bit.';
}
