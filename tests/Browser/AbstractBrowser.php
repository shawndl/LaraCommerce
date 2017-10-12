<?php

namespace Tests\Browser;

use App\Category;
use App\Image;
use App\Product;
use App\Role;
use App\Sale;
use App\Tax;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\ShoppingCart\Item;
use Syscover\ShoppingCart\TaxRule;
use Tests\DuskTestCase;

class AbstractBrowser extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * adds a product to the database
     * @return Product
     */
    public function addProduct($number = 1)
    {
        factory(Category::class)->create(['name' => 'clothes']);
        factory(Tax::class)->create(['name' => 'local']);
        factory(Image::class)->create();
        if($number === 1)
        {
            $override = [
                'title' => 'book',
                'description' => 'A basic book.'
            ];
        } else {
            $override = [];
        }

        return factory(Product::class, $number)->create($override);
    }

    /**
     * adds a sale to a product
     */
    public function addSale()
    {
        $this->addProduct();
        return factory(Sale::class)->create([
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

    /**
     * add a tax
     *
     * @param array $override
     * @return mixed
     */
    public function addTax($override = [])
    {
        return factory(Tax::class)->create($override);
    }

    /**
     * creates a shopping cart with 5 items in it
     *
     * @return void
     */
    public function addShoppingCart()
    {
        $this->addProduct(5);
        foreach(Product::all() as $product)
        {
            CartProvider::instance()
                ->add(new Item($product->id,
                    $product->title,
                    1,
                    $product->price,
                    $product->weight,
                    true,
                    new TaxRule(
                        'local',
                        20)));
        }
    }
}
