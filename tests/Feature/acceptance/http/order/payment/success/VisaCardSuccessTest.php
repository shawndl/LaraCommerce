<?php
/*
|--------------------------------------------------------------------------
| VisaCardSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to complete an order
|    As a user
|    I need pay pay with a visa card
|
| Scenario:
|   Given: I entered my visa card number
|   And: All the information is correct
|   When: I submit my card information
|   Then: I should receive a success message
|   And:  Paid for should be set to true
*/
namespace Tests\Feature\acceptance\http\order\payment\success;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisaCardSuccessTest extends AbstractPaymentSuccess
{
    //Please read the comments above for details about the test
    protected $cardResponse = 'visa';
    
}
