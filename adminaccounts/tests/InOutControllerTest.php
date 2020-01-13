<?php

namespace App\Http\Controllers;

use App\Account;
use App\Fee;
use App\Http\Controllers\Utils\LogManger;
use App\InOut;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;
use MongoDB\BSON\Decimal128;


class InOutControllerTest extends \TestCase
{

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/inOut', [
            'account_id'=>factory(Account::class)->create()->id,
            'in'=>Carbon::now()->toString(),
            'status'=>'active'

        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testList()
    {
        factory(InOut::class, 30)->create();
        $response = $this->json('GET', '/inOut');

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => ['*' => [
                'id',
                'type',
                'attributes' => [
                    'account_id',
                    'temp_license',
                    'in',
                    'out',
                    'status',
                    'created_at',
                    'updated_at',
                ]]],
            'error',
            'status'
        ]);

    }

    public function testOne()
    {
        $data = factory(InOut::class)->create();
        $response = $this->json('GET', '/inOut/'.$data->id);

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => [
                'id',
                'type',
                'attributes' => [
                    'account_id',
                    'temp_license',
                    'in',
                    'out',
                    'status',
                    'created_at',
                    'updated_at',
                ]],
            'error',
            'status'
        ]);

    }

    public function testUpdate()
    {
        $faker = Faker::create();
        $data = factory(InOut::class)->create([
            'account_id'=>factory(Account::class)->create()->id,
            'in'=>Carbon::now()->subMinutes(3)->toString(),

        ]);
        $response = $this->json('PUT', '/inOut/' . $data->id, [
            'out'=>Carbon::now()->toString(),
            'status'=>'close',
        ]);

        $rData = json_decode($this->response->getContent());

        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue($receive_json->data===0);

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data',
            'error',
            'status'
        ]);

    }

    public function testUpdateNoaccount()
    {
        $faker = Faker::create();
        $dataFee = factory(Fee::class)->create(['name'=>'NO_RESIDENT','value'=>0.75]);
        $data = factory(InOut::class)->create(
            [
                'in'=>Carbon::now()->subDays(3)->toString(),
                'account_id'=>null,
                'temp_license'=>$faker->bankAccountNumber,
            ]
        );
        $response = $this->json('PUT', '/inOut/' . $data->id, [
            'out'=>Carbon::now()->addMinute()->toString(),
            'status'=>'close',
        ]);

        $rData = json_decode($this->response->getContent());
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue($receive_json->data!=0);

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data',
            'error',
            'status'
        ]);

    }

    public function testDelete()
    {
        $data = factory(InOut::class)->create();
        $response = $this->json('DELETE', '/inOut/' . $data->id);


        $response->assertResponseStatus(200);
        $rData = json_decode($this->response->getContent());
        $this->assertEquals($rData->data, null);
        $this->seeJsonStructure([
            'message',
            'data',
            'error',
            'status'
        ]);

    }
}
