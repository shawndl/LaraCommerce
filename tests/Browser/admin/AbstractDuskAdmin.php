<?php

namespace Tests\Browser\admin;

use App\Category;
use App\Image;
use App\Product;
use App\Role;
use App\Sale;
use App\Tax;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AbstractDuskAdmin extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * adds a product to the database
     */
    public function addProduct()
    {
        factory(Category::class)->create(['name' => 'clothes']);
        factory(Tax::class)->create(['name' => 'local']);
        factory(Image::class)->create();
        factory(Product::class)->create([
            'title' => 'book',
            'description' => 'A basic book.'
        ]);
    }

    /**
     * adds a sale to a product
     */
    public function addSale()
    {
        $this->addProduct();
        factory(Sale::class)->create([
            'discount' => '0.25'
        ]);
    }

    /**
     * creates a user and returns it
     *
     * @param bool $admin
     * @return User
     */
    public function addUser($admin = false)
    {
        $user = factory(User::class)->create();
        if($admin)
        {
            factory(Role::class)->create();
            $role = Role::first();
            $user->assignRole($role);
        }
        return $user;
    }

    /**
     * add a category
     *
     * @param array $override
     * @return mixed
     */
    public function addCategory($override = [])
    {
        return factory(Category::class)->create($override);
    }
}
