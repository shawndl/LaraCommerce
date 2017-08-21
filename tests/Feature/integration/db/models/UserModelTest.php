<?php

namespace Tests\Feature\integration\db\models;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserModelTest extends TestCase
{
    use DatabaseMigrations, \SetUpAddressTrait;

    /**
     * @var User
     */
    protected $userAddresses;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpAddress();
        $this->userAddresses = User::userAddresses($this->user->id);
    }

    /** @test */
    public function it_must_be_able_to_return_all_of_the_users_addresses()
    {
        $this->assertCount(3, $this->userAddresses);
    }
    
    /** @test */
    public function it_must_be_able_to_return_the_state()
    {
        $this->assertEquals('Colorado', $this->userAddresses[0]->state->name);
    }
}
