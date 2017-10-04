<?php
/*
|--------------------------------------------------------------------------
| DeleteTaxFailAuthTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent users from deleting taxes
|    As a user or a guest
|    I want to delete a tax
|
| Scenario:
|   Given: I am a user or a guest
|   When: I submit a request to a delete tax
|   Then: I should receive a redirect or an error message
*/
namespace Tests\Feature\acceptance\admin\tax;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class DeleteTaxFailAuthTest extends AbstractHttpAjaxTestClass
{
    use \SetUpTaxTrait;

    protected $postRoute = 'admin/api/categories';

    protected $post = ['_method' => 'DELETE'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpTax();
        $this->postRoute = $this->postRoute . '/' . $this->tax->id;
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->setPostResponse(['_method' => 'DELETE']);
        $this->postResponse->assertStatus(401);
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function users_can_not_submit_this_form()
    {
        $this->setPostResponseUser(['_method' => 'DELETE']);
        $this->postResponse->assertStatus(404);
    }
}
