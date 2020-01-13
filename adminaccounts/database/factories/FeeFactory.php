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


$factory->define(\App\Fee::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word,
        'type_park'=>$faker->bankAccountNumber,
        'value'=>$faker->numberBetween(0.25,0.50),
    ];
});
