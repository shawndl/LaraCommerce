<?php

namespace Tests\Feature\acceptance\http;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractHttpTestClass extends TestCase
{
    use DatabaseMigrations, \SetUpUserTrait;
    /**
     * @var TestResponse
     */
    protected $getResponse;

    /**
     * @var TestResponse
     */
    protected $postResponse;

    /**
     * @var string
     */
    protected $getRoute = '/';

    /**
     * @var string
     */
    protected $postRoute = '/';

    protected function setUp()
    {
        parent::setUp();
        $this->setGetResponse();
    }

    /**
     * sets the response parameter
     *
     * @return void
     */
    protected function setGetResponse()
    {
        $this->getResponse = $this->call('GET', $this->getRoute);
    }

    /**
     * sets the get response as acting as a user
     *
     * @return void
     */
    protected function setGetResponseUser()
    {
        $this->destroyUsers();
        $this->setUpUser();
        $this->getResponse = $this->actingAs($this->user)
            ->call('GET', $this->getRoute);
    }


    /**
     * sets the get response with a session
     *
     * @param array $session
     * @return void
     */
    protected function setGetResponseSession($session)
    {
        $this->getResponse = $this->withSession($session)
            ->call('GET', $this->getRoute);
    }

    /**
     * sets the get response with a user and a session
     *
     * @param array $session
     * @return void
     */
    protected function setGetResponseUserSession($session)
    {
        $this->destroyUsers();
        $this->setUpUser();
        $this->getResponse = $this->withSession($session)
            ->actingAs($this->user)
            ->call('GET', $this->getRoute);
    }

    /**
     * sets the post response
     *
     * @param $post
     * @return void
     */
    protected function setPostResponse($post)
    {
        $this->postResponse = $this->call('POST', $this->postRoute, $post);
    }

    /**
     * sets the post response
     *
     * @param $post
     * @return void
     */
    protected function setPostResponseUser($post)
    {
        $this->destroyUsers();
        $this->setUpUser();
        $this->postResponse = $this->actingAs($this->user)
            ->call('POST', $this->postRoute, $post);
    }
}
