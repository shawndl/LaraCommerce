<?php

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 10/8/17
 * Time: 10:44 AM
 */
trait SetUpTaxTrait
{
    /**
     * @var \App\Tax
     */
    protected $tax;

    public function setUpTax()
    {
        $this->tax = \App\Tax::create([
           'name' => 'local tax',
            'percent' => .02,
            'description' => 'A local tax'
        ]);
    }
}