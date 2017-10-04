<?php
/*
|--------------------------------------------------------------------------
| UpdateTaxFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from updating taxes
|    As a user or a guest
|    I want to update a tax
|
| Scenario:
|   Given: I am a user or a guest
|   When: I submit a request for to update a tax
|   Then: I should receive a redirect or an error message
*/
namespace Tests\Feature\acceptance\admin\tax;

use App\Tax;
use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class UpdateTaxFailAuthTest extends AbstractHttpAjaxTestClass
{
    protected $postRoute = 'admin/api/taxes';

    /**
     * @var Tax
     */
    protected $tax;

    protected function setUp()
    {
        parent::setUp();
        $this->tax = factory(Tax::class)->create();
        $this->postRoute = $this->postRoute . '/' . $this->tax->id;
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['_method' => 'Patch']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_this_form()
    {
        $this->setPostResponseUser(['_method' => 'Patch']);
        $this->postResponse->assertStatus(302);
    }
}
