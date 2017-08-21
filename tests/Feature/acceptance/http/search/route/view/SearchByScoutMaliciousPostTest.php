<?php
/*
|--------------------------------------------------------------------------
| SearchByScoutMaliciousPostTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from attacking our system
|    As a user
|    I want to inject some javascript into my search
|
| Scenario:
|   Given: I am a malicious user
|   And: I enter some malicious javascript into the search bar
|   When: when I post of SearchController@scout
|   Then: I should be redirect to the home screen with an error
*/
namespace Tests\Feature\acceptance\http\search\route\view;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class SearchByScoutMaliciousPostTest extends AbstractHttpTestClass
{
    protected $postRoute = 'products';

    protected $post = ['search' => "javascript:alert('hi')"];

    protected function setUp()
    {
        parent::setUp();
        $this->setPostResponse($this->post);
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function if_the_users_search_contains_forbidden_characters_then_they_will_be_redirected_back_with_errors()
    {
        $this->postResponse->assertRedirect('/');
    }

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function a_forbidden_character_search_must_return_errors()
    {
        $this->postResponse->assertSessionHasErrors(['search'
        => 'The search may only contain letters, numbers, punctuation, and spaces.']);
    }
}
