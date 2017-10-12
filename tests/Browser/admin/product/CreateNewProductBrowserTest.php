<?php

namespace Tests\Browser\admin\product;

use Tests\Browser\admin\AbstractDuskAdmin;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateNewProductBrowserTest extends AbstractDuskAdmin
{
    use DatabaseMigrations;

    /**
     * @test
     * @group product
     * @group admin
     */
    public function it_must_be_able_to_create_a_product()
    {
        $user = $this->addUser(true);
        $this->addProduct();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('admin/products')
                ->assertSee('Products Page')
                ->pause(2000)
                ->pressAndWaitFor('Create New Product', ['seconds', 3])
                ->assertSee('Add a Product')
                ->type('title', 'Book')
                ->type('price', 9.99)
                ->type('weight', 2.3929)
                ->type('description', 'A new book')
                ->pause(1000)
                ->select('category')
                ->select('tax')
                ->type('image', 'http://via.placeholder.com/150x150')
                ->type('thumbnail', 'http://via.placeholder.com/150x150')
                ->press('Add')
                ->pause(2000)
                ->assertSee('You have created a new product!');
            $this->assertDatabaseHas('products', [
               'title' => 'Book'
            ]);
        });
    }
}
