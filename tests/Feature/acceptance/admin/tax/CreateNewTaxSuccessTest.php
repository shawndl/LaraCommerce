<?php
/*
|--------------------------------------------------------------------------
| CreateNewTaxSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow users to add taxes to the database
|    As a admin
|    I need create a new tax
|
| Scenario:
|   Given: I am an admin
|   When: I submit a form for a new tax
|   Then: A new tax should be created
*/
namespace Tests\Feature\acceptance\admin\tax;

use Tests\Feature\acceptance\admin\AbstractTestPost;


class CreateNewTaxSuccessTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/taxes';

    protected $post = ['name' => 'local', 'percent' => 0.09, 'description' => 'A local tax'];

    protected function setUp()
    {
        parent::setUp();
        $this->sendRequest();
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson(['message' => 'You have created a new tax!']);
    }

    /**
     * @group tax
     * @group acceptance
     * @test
     */
    public function it_must_have_the_new_category_in_the_database()
    {
        $this->assertDatabaseHas('taxes', $this->post);
    }
}
