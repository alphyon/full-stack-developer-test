<?php

namespace App\Http\Repositories;


use App\Account;
use App\InOut;


class InOutRepositoryTest extends \TestCase
{

    public function testFindbyparam()
    {
        $owner = factory(InOut::class)->create();
        factory(InOut::class)->create();
        factory(InOut::class)->create();
        factory(InOut::class)->create();
        factory(InOut::class)->create();
        factory(InOut::class)->create();
        factory(InOut::class)->create();
        $repo = new InOutRepository(new InOut());
        $found = $repo->findbyparam('value',$owner->value);
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual(2,$found->count());

    }

    public function testCreate()
    {
        $date = \Carbon\Carbon::now();

        $account = [
            'account_id'=>factory(Account::class)->create()->id,
            'temp_license'=>null,
            'in'=>$date->toString(),
            'out'=>null,
            'status'=>'active'
        ];
        $repo = new InOutRepository(new InOut());

        $test = $repo->create($account);

        $this->assertEquals($account['in'],$test->in);


    }

    public function testUpdate()
    {
        $date = \Carbon\Carbon::now();
        $data = factory(InOut::class)->create();
        $dataUpdate = [
            'out'=>$date,
            'status'=>'close' ,
        ];
        $repo = new InOutRepository($data);
        $account = $repo->update($dataUpdate);
        $this->assertTrue($account);


    }

    public function testFind()
    {
        $data = factory(InOut::class)->create();
        $repo = new InOutRepository(new InOut());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(InOut::class, $found);
        $this->assertEquals($found->account_id, $data->account_id);

    }

    public function testAll()
    {
        $element = factory(InOut::class, 5)->create();
        $accounts = new InOutRepository(new InOut());
        $data = $accounts->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(InOut::class)->create();
        $repo =  new InOutRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
