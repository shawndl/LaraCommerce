<?php

namespace Tests\Feature\unit\classes;

use App\Library\API\ApiResponseTracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiResponseTrackerTest extends TestCase
{
    /**
     * @var ApiResponseTracker
     */
    protected $tracker;

    /**
     * @var array
     */
    protected $array = [];

    public function setUp()
    {
        $this->tracker = new ApiResponseTracker();
        $this->tracker->setResult(422, 'Your record was not found', true, [
           'id' => 33,
            'name' => 'book'
        ]);
        $this->array = $this->tracker->getResult();
    }

    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_set_a_message()
    {
        $this->assertEquals('Your record was not found', $this->array['status']);
    }
    
    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_set_a_code()
    {
        $this->assertEquals(422, $this->array['code']);
    }
    
    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_set_an_additional_data_array()
    {
        $this->assertEquals(33, $this->array['data']['id']);
        $this->assertEquals('book', $this->array['data']['name']);
    }
    
    /**
     * @test
     * @group unit
     */
    public function it_must_be_able_to_return_if_an_error_has_been_set()
    {
        $this->assertTrue($this->tracker->hasError());
    }
    
     /**
      * @test
      * @group unit
      */
     public function it_must_not_allow_any_messages_to_be_set_if_error_is_set_to_true()
     {
         $this->tracker->setResult(200, 'No Problem!');
         $this->assertEquals('Your record was not found', $this->tracker->getResult()['status']);
     }
}
