<?php
/*
|--------------------------------------------------------------------------
| UpdateTaxSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to allow admins to update taxes to the database
|    As a admin
|    I need to update a tax
|
| Scenario:
|   Given: I am an admin
|   When: I submit a form for to update tax
|   Then: A tax must be updated
*/
namespace Tests\Feature\acceptance\admin\tax;

use App\Tax;
use Tests\Feature\acceptance\admin\AbstractTestPost;

class UpdateTaxSuccessTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/taxes';

    protected $tax;

    protected $post = ['name' => 'local', 'percent' => 0.09, 'description' => 'A local tax'];

    protected function setUp()
    {
        parent::setUp();
        $this->tax = factory(Tax::class)->create();
        $this->postRoute = $this->postRoute . '/' . $this->tax->id;
        $this->sendRequest(true);
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
        $this->postResponse->assertJson(['message' => "You updated a tax!"]);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_the_new_category_in_the_database()
    {
        $this->assertDatabaseHas('taxes', [
            'name' => 'local', 'percent' => 0.09, 'description' => 'A local tax'
        ]);

        $this->assertDatabaseMissing('taxes', [
            'name' => $this->tax->name
        ]);
    }

}
