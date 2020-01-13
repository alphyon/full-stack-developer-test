<?php

namespace App\Http\Repositories;


use App\Park;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Faker\Factory as Faker;


class ParksRepositoryTest extends \TestCase
{
    use DatabaseMigrations;





    public function testFindbyparam()
    {
        factory(Park::class)->create(['name'=>'offcial']);
        factory(Park::class)->create();
        $repo = new ParksRepository(new Park());
        $found = $repo->findbyparam('name','official');
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual($found->count(),1);

    }

    public function testCreate()
    {
        $faker = Faker::create();
        $park = [
            'name'=>$faker->word,
            'description'=>$faker->word,

        ];
        $repo = new ParksRepository(new Park());

        $test = $repo->create($park);

        $this->assertEquals($park['name'],$test->name);


    }

    public function testUpdate()
    {
        $data = factory(Park::class)->create();
        $dataUpdate = [
            'owner' => 'Martin',
            'type' => 'official',
        ];
        $repo = new ParksRepository($data);
        $car = $repo->update($dataUpdate);
        $this->assertTrue($car);


    }

    public function testFind()
    {
        $data = factory(Park::class)->create();
        $repo = new ParksRepository(new Park());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(Park::class, $found);
        $this->assertEquals($found->license, $data->license);
        $this->assertEquals($found->owner, $data->owner);

    }

    public function testAll()
    {
        factory(Park::class, 5)->create();
        $cars = new ParksRepository(new Park());
        $data = $cars->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(Park::class)->create();
        $repo =  new ParksRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
