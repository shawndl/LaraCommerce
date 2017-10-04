<?php

namespace Tests\Feature\acceptance\admin\sale;


use Tests\Feature\acceptance\admin\AbstractTestPost;

class AbstractTestSale extends AbstractTestPost
{
    use \SetUpProductsTrait;

    /**
     * @var array
     */
    protected $post = [
        'start' =>  '2017-09-18T00:06:15.687Z',
        'finish' => '2017-09-22T00:06:17.925Z',
        'discount' => 0.25,
        'product_id' => ''
    ];

    protected $postRoute = 'admin/products/sales';

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProduct();
        $this->post['product_id'] = $this->products[0]->id;
    }
}
