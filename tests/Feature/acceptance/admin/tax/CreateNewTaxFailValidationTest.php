<?php
/*
|--------------------------------------------------------------------------
| CreateNewTaxFailValidationTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature:
|    In order to prevent bad data
|    As a admin
|    I need create a new tax
|
| Scenario:
|   Given: I am an admin
|   And:  I submit bad data
|   When: I submit a form for a new tax
|   Then: A must receive an error
*/
namespace Tests\Feature\acceptance\admin\tax;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class CreateNewTaxFailValidationTest extends AbstractTestPost
{
    protected $postRoute = 'admin/api/taxes';

    protected $post = ['name' => 'local', 'description' => 'A Description', 'percent' => 0.09];

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function validation_errors_must_return_a_status_of_422()
    {
        $this->post['name'] = '';
        $this->sendRequest();
        $this->postResponse->assertStatus(422);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_a_name()
    {
        $this->post['name'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name field is required.']);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_only_letters_and_spaces()
    {
        $this->post['name'] = '281 Cows';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The name may only contain letters and spaces.']);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_a_description()
    {
        $this->post['description'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The description field is required.']);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function the_description_must_have_only_basic_characters()
    {
        $this->post['description'] = '281 Cows javascript:void()';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The description may only contain letters, numbers, punctuation, and spaces.']);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_a_percent()
    {
        $this->post['percent'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The percent field is required.']);
    }

    /**
     * @group tax
     * @group acceptance
     * @group admin
     * @test
     */
    public function the_description_must_have_only_basic_spaces()
    {
        $this->post['percent'] = '281 Cows javascript:void()';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The percent format is invalid.']);
    }
}