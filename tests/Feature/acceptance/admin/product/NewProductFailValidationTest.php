<?php

namespace Tests\Feature\acceptance\admin\product;



class NewProductFailValidationTest extends AbstractNewProduct
{
    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_title_is_required()
    {
        $this->post['title'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The title field is required.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_title_must_only_contain_letters_and_spaces()
    {
        $this->post['title'] = 'The new $(@(@';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The title may only contain letters and spaces.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_description_is_required()
    {
        $this->post['description'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The description field is required.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_description_must_contain_only_basic_characters()
    {
        $this->post['description'] = 'This is a new book.';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['You have created a new product!']);

        $this->post['description'] = 'This is a new book<?php echo hi ?>';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The description may only contain letters, numbers, punctuation, and spaces.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_category_is_required()
    {
        $this->post['category'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The category field is required.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_category_must_only_contain_numbers()
    {
        $this->post['category'] = 'clothes';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The category must be a number.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_price_is_required()
    {
        $this->post['price'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The price field is required.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_price_must_only_be_a_decimal_with_2_digits()
    {
        $this->post['price'] = 202;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The price format is invalid.']);

        $this->post['price']= 19.092;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The price format is invalid.']);

        $this->post['price'] = 22.1;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The price format is invalid.']);

        $this->post['price'] = 19.99;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['You have created a new product!']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_weight_is_required()
    {
        $this->post['weight'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The weight field is required.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_weight_must_only_be_a_decimal()
    {
        $this->post['weight'] = 19;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['You have created a new product!']);

        $this->post['weight'] = 19.20;
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['You have created a new product!']);

        $this->post['weight'] = "19.920";
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['You have created a new product!']);

        $this->post['weight'] = "cow";
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The weight format is invalid.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function if_the_image_upload_is_null_then_the_image_is_required()
    {
        $this->upload_image = '';
        $this->post['image'] = '';
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The image field is required when upload is not present.']);
    }

    /**
     * @group products
     * @group admin
     * @group acceptance
     * @test
     */
    public function the_image_must_be_a_url()
    {
        $this->post['image'] = "cow";
        $this->sendRequest();
        $this->postResponse->assertJsonFragment(['The image format is invalid.']);
    }
}
