<?php

namespace App\Http\Repositories;


use App\Fee;


class FeesRepositoryTest extends \TestCase
{

    public function testFindbyparam()
    {
        $owner = factory(Fee::class)->create();
        factory(Fee::class)->create();
        factory(Fee::class)->create();
        factory(Fee::class)->create();
        factory(Fee::class)->create();
        factory(Fee::class)->create();
        factory(Fee::class)->create();
        $repo = new FeesRepository(new Fee());
        $found = $repo->findbyparam('value',$owner->value);
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual(2,$found->count());

    }

    public function testCreate()
    {
        $account = [
            'name'=>'test',
            'type_park'=>'test001',
            'value'=>'0.75' ,
        ];
        $repo = new FeesRepository(new Fee());

        $test = $repo->create($account);

        $this->assertEquals($account['value'],$test->value);


    }

    public function testUpdate()
    {
        $data = factory(Fee::class)->create();
        $dataUpdate = [
            'name'=>'update',
            'type_park'=>'test001',
            'value'=>'1' ,
        ];
        $repo = new FeesRepository($data);
        $account = $repo->update($dataUpdate);
        $this->assertTrue($account);


    }

    public function testFind()
    {
        $data = factory(Fee::class)->create();
        $repo = new FeesRepository(new Fee());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(Fee::class, $found);
        $this->assertEquals($found->value, $data->value);

    }

    public function testAll()
    {
        $element = factory(Fee::class, 5)->create();
        $accounts = new FeesRepository(new Fee());
        $data = $accounts->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(Fee::class)->create();
        $repo =  new FeesRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
