<?php

namespace Tests\Feature\acceptance\http\order\payment\failed;

use Tests\Feature\acceptance\http\order\payment\AbstractPayment;

class AbstractPaymentFailure extends AbstractPayment
{
    protected $status = 422;

    protected $paidFor = 0;
}
