<?php

namespace Tests\Feature\acceptance\http\address;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class GetStatesTest extends AbstractHttpAjaxTestClass
{
    use \SetUpAddressTrait;
    protected $getRoute = 'get-states';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpState();
        $this->setGetResponse();
    }

    /**
     * @group acceptance
     * @group addresses
     * @test
     */
    public function it_must_return_the_states_in_the_database()
    {
        $this->getResponse->assertJson(['states' => [
            1 => "Colorado"
        ]]);
    }
}
