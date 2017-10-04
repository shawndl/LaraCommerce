<?php

namespace Tests\Feature\acceptance\admin\product;


use Tests\Feature\acceptance\admin\AbstractTestPost;


class AbstractNewProduct extends AbstractTestPost
{
    use \SetUpCategoryTrait, \SetUpTaxTrait;

    /**
     * @var string
     */
    protected $postRoute = 'admin/products';

    /**
     * @var array
     */
    protected $post = [
        'title' => 'A Book',
        'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
        'price' => 9.99,
        'weight' => 1.3030,
        'image' => 'http://via.placeholder.com/150x150',
        'tax' => null,
        'category' => null,
        'thumbnail' => 'http://via.placeholder.com/50x50'
    ];

    /**
     * @var
     */
    protected $upload_image;

    /**
     * @var bool
     */
    protected $upload = false;

    public function setUp()
    {
        parent::setUp();
        $this->setUpTax();
        $this->setUpCategory();
        $this->post['tax'] = $this->tax->id;
        $this->post['category'] = $this->category->id;
    }

    /**
     * sends a request for a new product
     *
     * @param bool $update
     * @param bool $isAdmin
     * @return void
     */
    protected function sendRequest($update = false, $isAdmin = true)
    {
        if($this->upload)
        {
            $this->post['upload'] = $this->upload_image;
            unset($this->post['image']);
        }
        if($update)
        {
            $post['_method'] = "PATCH";
        }
        parent::sendRequest($update, $isAdmin);
    }
}
