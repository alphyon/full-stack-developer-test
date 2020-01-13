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


$factory->define(\App\InOut::class, function (Faker\Generator $faker) {
    $date = \Carbon\Carbon::now();
    return [
        'account_id'=>factory(\App\Account::class)->create()->id,
        'in'=>$date->toString(),
        'out'=>$date->add(1,'day'),
        'status'=>$faker->randomElement(['active','close'])
    ];
});
