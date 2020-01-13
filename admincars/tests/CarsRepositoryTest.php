<?php

namespace App\Http\Repositories;


use App\Car;
use Illuminate\Validation\Rules\DatabaseRule;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;


class CarsRepositoryTest extends \TestCase
{





    public function testFindbyparam()
    {
        $owner = factory(Car::class)->create();
        factory(Car::class)->create();
        factory(Car::class)->create();
        factory(Car::class)->create();
        factory(Car::class)->create();
        factory(Car::class)->create();
        factory(Car::class)->create();
        $repo = new CarsRepository(new Car());
        $found = $repo->findbyparam('owner',$owner->owner);
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual($found->count(),2);

    }

    public function testCreate()
    {
        $faker = Faker::create();
        $car = [
            'license'=>$faker->word,
            'model'=>$faker->word,
            'color'=>$faker->colorName,
            'owner'=>$faker->name,
        ];
        $repo = new CarsRepository(new Car());

        $test = $repo->create($car);

        $this->assertEquals($car['model'],$test->model);


    }

    public function testUpdate()
    {
        $data = factory(Car::class)->create();
        $dataUpdate = [
            'owner' => 'Martin',
            'type' => 'official',
        ];
        $repo = new CarsRepository($data);
        $car = $repo->update($dataUpdate);
        $this->assertTrue($car);


    }

    public function testFind()
    {
        $data = factory(Car::class)->create();
        $repo = new CarsRepository(new Car());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(Car::class, $found);
        $this->assertEquals($found->license, $data->license);
        $this->assertEquals($found->owner, $data->owner);

    }

    public function testAll()
    {
        factory(Car::class, 5)->create();
        $cars = new CarsRepository(new Car());
        $data = $cars->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(Car::class)->create();
        $repo =  new CarsRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
