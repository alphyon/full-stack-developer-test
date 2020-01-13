<?php

namespace App\Http\Controllers;

use App\Account;
use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;


class AccountsControllerTest extends \TestCase
{
    use DatabaseMigrations;

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/account', [
            'car_license' => $faker->bankAccountNumber,
            'fee_id' => factory(\App\Fee::class)->create()->id,
            'month_minutes' => '0',

        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testList()
    {
        factory(Account::class, 30)->create();
        $response = $this->json('GET', '/account');

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => ['*' => [
                'id',
                'type',
                'attributes' => [
                    'car_license',
                    'fee_id',
                    'month_minutes',
                    'created_at',
                    'updated_at',
                ]]],
            'error',
            'status'
        ]);

    }

    public function testUpdate()
    {
        $faker = Faker::create();
        $data = factory(Account::class)->create();
        $response = $this->json('PUT', '/account/' . $data->id, [
            'car_license' => $faker->bankAccountNumber,
            'fee_id' => 'fdfgdfg',
            'month_minutes' => '454564',
        ]);

        $rData = json_decode($this->response->getContent());

        $this->assertNotEquals($rData->data->fee_id, $data->fee_id);

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
        $data = factory(Account::class)->create();
        $response = $this->json('DELETE', '/account/' . $data->id);


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
