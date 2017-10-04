<?php
/*
|--------------------------------------------------------------------------
| CreateCategoriesFailValidationTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent bad category data
|    As a admin
|    I need create a new category
|
| Scenario:
|   Given: I am an admin who wants to create a new category
|   And: I have provided bad data
|   When: I submit
|   Then: I should receive a 422 with an error
*/
namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\admin\AbstractTestPost;


class CreateCategoriesFailValidationTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/categories';

    protected $post = ['name' => ''];

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function validation_errors_must_return_a_status_of_422()
    {
        $this->sendRequest();
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_have_a_name()
    {
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name field is required.']);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_have_only_letters_and_spances()
    {
        $this->post['name'] = '281 Cows';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name may only contain letters and spaces.']);
    }
}
