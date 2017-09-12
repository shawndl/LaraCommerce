<?php

namespace Tests\Feature\acceptance\http\order\route\update;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOrderFailedValidationTest extends AbstractFailedUpdateOrder
{
    use \SetUpOrderTrait;
    /**
     * @var integer
     */
    protected $code = 422;

    /**
     * @var array
     */
    protected $message = [
        "address_id" => [
            "The address id must be a number."
        ]
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->setUpOrderDatabase(true);
        $this->postRoute = 'order/' . $this->orders[0]->id;
        $this->setPostResponseUser([
            '_method' => 'PATCH',
            'address_id' => 'candy'
        ]);
    }
}
