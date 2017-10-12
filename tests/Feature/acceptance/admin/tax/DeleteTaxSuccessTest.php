<?php
/*
|--------------------------------------------------------------------------
| DeleteTaxSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow admins to delete taxes from the database
|    As a admin
|    I need create a new tax
|
| Scenario:
|   Given: I am an admin
|   When: I submit a form for to delete tax
|   Then: The tax must be deleted
*/
namespace Tests\Feature\acceptance\admin\tax;

use App\Tax;
use Tests\Feature\acceptance\admin\AbstractTestPost;

class DeleteTaxSuccessTest extends AbstractTestPost
{
    protected $tax;

    protected $postRoute = 'admin/api/taxes';

    protected $post = ['_method' => 'DELETE'];

    protected function setUp()
    {
        parent::setUp();
        $this->tax = factory(Tax::class)->create();
        $this->postRoute = $this->postRoute . '/' . $this->tax->id;
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
        $this->postResponse
            ->assertStatus(200);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson([
            'message' => 'You deleted a tax!'
        ]);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_delete_the_category_from_the_database()
    {
        $this->assertDatabaseMissing('taxes', [
            'name' => $this->tax->name
        ]);
    }
}
