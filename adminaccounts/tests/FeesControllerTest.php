<?php

namespace App\Http\Controllers;

use App\Fee;
use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;


class FeesControllerTest extends \TestCase
{
    use DatabaseMigrations;

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/fee', [
            'type_park' => $faker->bankAccountNumber,
            'value' => factory(\App\Fee::class)->create()->id,


        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testSHow()
    {
        $fee = factory(Fee::class)->create();
        $response = $this->json('GET', '/fee/' . $fee->id);

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => [
                'id',
                'type',
                'attributes' => [
                    'name',
                    'type_park',
                    'value',
                    'created_at',
                    'updated_at',
                ]],
            'error',
            'status'
        ]);

    }

    public function testList()
    {
        factory(Fee::class, 30)->create();
        $response = $this->json('GET', '/fee');

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => ['*' => [
                'id',
                'type',
                'attributes' => [
                    'name',
                    'type_park',
                    'value',
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
        $data = factory(Fee::class)->create();
        $response = $this->json('PUT', '/fee/' . $data->id, [
            'type_park' => 'fdfgdfg',
            'value' => '454564',
        ]);

        $rData = json_decode($this->response->getContent());

        $this->assertNotEquals($rData->data->value, $data->value);

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
        $data = factory(Fee::class)->create();
        $response = $this->json('DELETE', '/fee/' . $data->id);


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
