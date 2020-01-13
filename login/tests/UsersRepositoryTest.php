<?php

namespace App\Http\Repositories;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Validation\Rules\DatabaseRule;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use phpseclib\Crypt\Hash;


class UsersRepositoryTest extends \TestCase
{





    public function testFindbyparam()
    {
        $owner = factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();
        $repo = new UsersRepository(new User());
        $found = $repo->findbyparam('email',$owner->email);
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual($found->count(),2);

    }

    public function testCreate()
    {
        $bc = new Controller();
        $faker = Faker::create();
        $user = [
            'name'=>$faker->word,
            'email'=>$faker->email,
            'password'=>$bc->bcrypt($faker->word),
        ];
        $repo = new UsersRepository(new User());

        $test = $repo->create($user);

        $this->assertEquals($user['name'],$test->name);


    }

    public function testUpdate()
    {
        $data = factory(User::class)->create();
        $dataUpdate = [
            'name' => ' juan perez',
        ];
        $repo = new UsersRepository($data);
        $car = $repo->update($dataUpdate);
        $this->assertTrue($car);


    }

    public function testFind()
    {
        $data = factory(User::class)->create();
        $repo = new UsersRepository(new User());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($found->email, $data->email);
        $this->assertEquals($found->name, $data->name);

    }

    public function testAll()
    {
        factory(User::class, 5)->create();
        $cars = new UsersRepository(new User());
        $data = $cars->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(User::class)->create();
        $repo =  new UsersRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
