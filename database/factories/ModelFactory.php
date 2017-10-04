<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function(Faker\Generator $faker){
    return [
        'name' => $faker->name
    ];
});

$factory->define(\App\Role::class, function () {
    return [
        'name' => 'admin'
    ];
});


$factory->define(App\Product::class, function(Faker\Generator $faker) {
    $categories = \App\Category::all()->pluck('id');
    $image = \App\Image::all()->pluck('id');
    $tax = \App\Tax::all()->pluck('id');
    return [
        'title' => $faker->realText($maxNbChars = 10, $indexSize = 2),
        'category_id' => $faker->randomElement($categories->toArray()),
        'image_id' => $faker->randomElement($image->toArray()),
        'tax_id' => $faker->randomElement($tax->toArray()),
        'price' => $faker->randomNumber(2),
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'weight' => $faker->randomFloat(3, 0.1, 50)
    ];
});

$factory->define(App\Review::class, function(Faker\Generator $faker) {
    $user = \App\User::all()->pluck('id');
    $product = \App\Product::all()->pluck('id');
    return [
        'user_id' => $faker->randomElement($user->toArray()),
        'product_id' =>  $faker->randomElement($product->toArray()),
        'stars' => rand(1, 5),
        'review' => $faker->paragraph
    ];
});

$factory->define(App\Image::class, function() {
    return [
        'path' =>  'http://via.placeholder.com/400x300',
        'thumbnail' => 'http://via.placeholder.com/200x150'
    ];
});


$factory->define(App\Address::class, function(Faker\Generator $faker) {
    $user = \App\User::all()->pluck('id');
    $states = \App\State::all()->pluck('id');

    return [
        'user_id' => $faker->randomElement($user->toArray()),
        'address' =>  $faker->streetAddress,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'state_id' => $faker->randomElement($states->toArray()),
    ];
});

$factory->define(App\State::class, function(Faker\Generator $faker) {
    return [
        'name' =>  $faker->state,
        'abbreviation' => $faker->stateAbbr
    ];
});

$factory->define(App\Order::class, function(Faker\Generator $faker) {
    $userIDs = \App\User::has('addresses')->pluck('id')->toArray();
    $user = \App\User::findOrFail($userIDs[array_rand($userIDs)]);
    $orderDate = $faker->date('Y-m-d H:i:s', 'now');
    $shipDate = new DateTime($orderDate);
    $shipDate->add(new DateInterval('P5D'));


    return [
        'user_id' => $user->id,
        'address_id' => $user->addresses()->first()->id,
        'order_date' => $orderDate,
        'ship_date' => $shipDate->format('Y-m-d H:i:s'),
        'total' => $faker->randomNumber(2),
        'sub_total' => $faker->randomNumber(2) * .9,
        'taxes' => 1.93
    ];
});

$factory->define(App\Tax::class, function(Faker\Generator $faker) {
    return [
        'name' =>  $faker->word,
        'percent' => $faker->randomFloat(3, 0, .3),
        'description' => $faker->sentence
    ];
});

$factory->define(App\Sale::class, function(Faker\Generator $faker) {
    $products = \App\Product::all()->pluck('id');
    return [
        'product_id' => $faker->randomElement($products->toArray()),
        'start' => $faker->dateTimeBetween('-14 days', 'now'),
        'finish' => $faker->dateTimeBetween('now', '+14 days'),
        'discount' => $faker->randomElement($array = array(.1, .15, .2, .25, .3, .35, .40))
    ];
});
