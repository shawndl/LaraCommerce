<?php
/*
|--------------------------------------------------------------------------
| SetUpSaleTrait.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for creating a sale
*/

trait SetUpSaleTrait
{
    use SetUpProductsTrait;

    /**
     * @var \App\Sale
     */
    protected $sale;

    /**
     * sets up the sale
     *
     * @return void
     */
    protected function setUpSale()
    {
        $this->sale = new \App\Sale();
        $this->setUpProduct();
        $this->sale = $this->sale->create([
            'start' => '2017-09-01',
            'finish' => '2017-09-20',
            'discount' => '0.25',
            'product_id' => $this->products[0]->id
        ]);
    }
}