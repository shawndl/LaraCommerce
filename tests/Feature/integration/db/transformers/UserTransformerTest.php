<?php

namespace Tests\Feature\integration\db\transformers;

use App\Library\Transformer\UserTransformer;
use SebastianBergmann\ObjectEnumerator\Fixtures\ExceptionThrower;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTransformerTest extends TestCase
{
    use DatabaseMigrations, \SetUpUserTrait;

    /**
     * @var array
     */
    protected $userTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpUser();
        $this->userTransformer = UserTransformer::transform($this->user);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_array_must_return_the_users_first_name()
    {
        $this->assertArrayHasKey('first_name', $this->userTransformer);
        $this->assertEquals($this->user->first_name, $this->userTransformer['first_name']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_array_must_return_the_users_last_name()
    {
        $this->assertArrayHasKey('last_name', $this->userTransformer);
        $this->assertEquals($this->user->last_name, $this->userTransformer['last_name']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_array_must_return_the_users_email_name()
    {
        $this->assertArrayHasKey('email', $this->userTransformer);
        $this->assertEquals($this->user->email, $this->userTransformer['email']);
    }

    /**
     * @test
     * @group integration
     * @group transformers
     */
    public function the_array_must_return_the_users_username()
    {
        $this->assertArrayHasKey('username', $this->userTransformer);
        $this->assertEquals($this->user->username, $this->userTransformer['username']);
    }
}
