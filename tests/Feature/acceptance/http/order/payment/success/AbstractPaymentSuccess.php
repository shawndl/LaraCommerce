<?php

namespace Tests\Feature\acceptance\http\order\payment\success;


use Tests\Feature\acceptance\http\order\payment\AbstractPayment;

abstract class AbstractPaymentSuccess extends AbstractPayment
{
    protected $status = 200;

    protected $message = 'Your payment was accepted!';

    protected $paidFor = 1;
}
