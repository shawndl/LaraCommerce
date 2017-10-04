<?php
/*
|--------------------------------------------------------------------------
| DeleteProductSuccessTest.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| Feature: 
|    In order to remove products from the database
|    As an administrator
|    I need delete a product
|
| Scenario: 
|   Given: I am an administrator that has selected for a product to be deleted
|   When: I submit my delete request
|   Then: the product should be deleted and I should receive a success message
*/
namespace Tests\Feature\acceptance\admin\product;


use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;

class DeleteProductSuccessTest extends AbstractHttpAjaxTestClass
{
    use \SetUpProductsTrait;
    /**
     * @var string
     */
    protected $postRoute = 'admin/products';

    /**
     * @var string
     */
    protected $productName;
    
    public function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->postRoute = $this->postRoute . '/' . $this->products[0]->id;
        $this->productName = $this->products[0]->title;
        $this->setPostResponseAdmin(['_method' => 'DELETE']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function it_must_return_a_success_message()
    {
        $this->postResponse->assertJson(["message" => "You deleted the book product!"]);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_product_must_be_deleted()
    {
        $this->assertDatabaseMissing('products', [
            'title' => $this->productName
        ]);
    }
}
