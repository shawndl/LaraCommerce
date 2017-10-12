<?php

namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\admin\AbstractTestPost;

class EditCategoriesSuccessTest extends AbstractTestPost
{
    use \SetUpCategoryTrait;

    protected $postRoute = 'admin/api/categories';

    protected $post = ['name' => 'electronics'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpCategory();
        $this->postRoute = $this->postRoute . '/' . $this->category->id;
        $this->sendRequest(true);
    }

    /**
     * @group category
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_a_status_of_200()
    {
        $this->postResponse->assertStatus(200);
    }

    /**
     * @group category
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson(['message' => "You edited the Electronics category!"]);
    }

    /**
     * @group category
     * @group acceptance
     * @group admin
     * @test
     */
    public function it_must_have_the_new_category_in_the_database()
    {
        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics'
        ]);

        $this->assertDatabaseMissing('categories', [
            'name' => 'Food'
        ]);
    }

}
