<?php
/*
|--------------------------------------------------------------------------
| SearchByGetFailedTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to protect users from malicious attacks
|    As a user
|    I receive an email with a link that contains malicious javascript code
|
| Scenario:
|   Given: I am a user
|   And: II click a link that contains malicious javascript
|   When: when I visit 'products/javascript:alert('hi')'
|   Then: I should be redirected to the homepage
*/
namespace Tests\Feature\acceptance\http\search\route\view;

use Tests\Feature\acceptance\http\AbstractHttpTestClass;

class SearchByGetFailedTest extends AbstractHttpTestClass
{
    protected $getRoute = 'products/javascript:alert(\'hi\')';

    /**
     *  @test
     *  @group search
     *  @group acceptance
     */
    public function it_must_return_a_redirect_to_the_home_page()
    {
        $this->getResponse->assertRedirect('/');
    }
}
