<?php

namespace Tests\Feature\acceptance\http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractHttpAjaxTestClass extends AbstractHttpTestClass
{
    /**
     * sets the response parameter
     *
     * @return void
     */
    protected function setGetResponse()
    {
        $this->getResponse = $this->json('GET', $this->getRoute);
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
            ->json('GET', $this->getRoute);
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
            ->json('GET', $this->getRoute);
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
            ->json('GET', $this->getRoute);
    }

    /**
     * sets the post response
     *
     * @param $post
     * @return void
     */
    protected function setPostResponse($post)
    {
        $this->postResponse = $this->json('POST', $this->postRoute, $post);
    }

    /**
     * sets the post response
     *
     * @param $post
     * @param bool $originalUser
     * @return void
     */
    protected function setPostResponseUser($post, $originalUser = true)
    {
        $this->destroyUsers();
        $this->setUpUser();
        $user = ($originalUser) ? $this->user : $this->secondUser;
        $this->postResponse = $this->actingAs($user)
            ->json('POST', $this->postRoute, $post);
    }
}
