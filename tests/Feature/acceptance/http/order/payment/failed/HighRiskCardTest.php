<?php

namespace Tests\Feature\acceptance\http\order\payment\failed;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HighRiskCardTest extends AbstractPaymentFailure
{
    //Please read the comments above for details about the test
    protected $cardResponse = 'highRiskCard';

    protected $message = 'Your card was declined.';
}
