<?php

namespace Tests\Feature\acceptance\admin;

use Tests\Feature\acceptance\http\AbstractHttpAjaxTestClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class AbstractTestPost extends AbstractHttpAjaxTestClass
{
    /**
     * @var array
     */
    protected $post = [];

    /**
     * sends a request for a new product
     *
     * @param bool $update
     * @param bool $isAdmin
     * @return void
     */
    protected function sendRequest($update = false, $isAdmin = true)
    {
        if($update)
        {
            $this->post['_method'] = "PATCH";
        }
        if(!$isAdmin)
        {
            $this->setPostResponseUser($this->post);
            return;
        }
        $this->setPostResponseAdmin($this->post);
    }
}
