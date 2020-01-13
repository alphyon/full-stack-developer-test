<?php

namespace App\Http\Repositories;


use App\Account;


class AccountsRepositoryTest extends \TestCase
{

    public function testFindbyparam()
    {
        $owner = factory(Account::class)->create();
        factory(Account::class)->create();
        factory(Account::class)->create();
        factory(Account::class)->create();
        factory(Account::class)->create();
        factory(Account::class)->create();
        factory(Account::class)->create();
        $repo = new AccountsRepository(new Account());
        $found = $repo->findbyparam('car_license',$owner->car_license);
        $this->assertIsArray($found->get()->toArray());
        $this->assertGreaterThanOrEqual($found->count(),2);

    }

    public function testCreate()
    {
        $account = [
            'car_license'=>'test001',
            'fee_id'=>factory(\App\Fee::class)->create()->id,
            'month_minutes'=>'328823' ,
        ];
        $repo = new AccountsRepository(new Account());

        $test = $repo->create($account);

        $this->assertEquals($account['car_license'],$test->car_license);


    }

    public function testUpdate()
    {
        $data = factory(Account::class)->create();
        $dataUpdate = [
            'owner' => 'Martin',
            'type' => 'official',
        ];
        $repo = new AccountsRepository($data);
        $account = $repo->update($dataUpdate);
        $this->assertTrue($account);


    }

    public function testFind()
    {
        $data = factory(Account::class)->create();
        $repo = new AccountsRepository(new Account());
        $found = $repo->find($data->id);
        $this->assertInstanceOf(Account::class, $found);
        $this->assertEquals($found->license, $data->license);
        $this->assertEquals($found->owner, $data->owner);

    }

    public function testAll()
    {
        $element = factory(Account::class, 5)->create();
        $accounts = new AccountsRepository(new Account());
        $data = $accounts->all();
        $this->assertIsArray($data->toArray());
        $this->assertTrue($data->count() > 2);

    }

    public function testDelete()
    {
        $data = factory(Account::class)->create();
        $repo =  new AccountsRepository($data);
        $delete = $repo->delete();
        $this->assertTrue($delete);

    }
}
