<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        //$this->call(SeedImageTable::class);
        $this->call(TaxTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ReviewTableSeeder::class);
        $this->call(StateTableSeeder::class);
        // $this->call(AddressTableSeeder::class);
        // $this->call(OrderTableSeeder::class);
        // $this->call(SaleTableSeeder::class);
    }
}
