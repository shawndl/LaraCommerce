<?php

namespace Tests\Feature\acceptance\admin\categories;

use Tests\Feature\acceptance\admin\AbstractTestPost;


class EditCategoriesFailAuthTest extends AbstractTestPost
{
    use \SetUpCategoryTrait;

    protected $postRoute = 'admin/api/categories';

    protected $post = ['name' => 'electronics'];

    protected function setUp()
    {
        parent::setUp();
        $this->setUpCategory();
        $this->postRoute = $this->postRoute . '/' . $this->category->id . '/edit';
        $this->sendRequest(true, false);
    }


    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function guests_can_not_submit_this_form()
    {
        $this->postResponse->assertStatus(405);
    }

    /**
     * @group category
     * @group acceptance
     * @test
     */
    public function it_must_not_update_the_database()
    {
        $this->assertDatabaseHas('categories', [
            'name' => $this->category->name
        ]);

        $this->assertDatabaseMissing('categories', [
            'name' => 'electronics'
        ]);
    }
}
