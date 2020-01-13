<?php

namespace App\Http\Controllers;

use App\Car;
use Faker\Factory as Faker;


class CarsControllerTest extends \TestCase
{

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/car', [
            'license' => $faker->word,
            'model' => $faker->word,
            'color' => $faker->colorName,
            'owner' => $faker->name,
            'type' => $faker->randomElement(['official', 'visit', 'member'])

        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testList()
    {
        factory(Car::class, 30)->create();
        $response = $this->json('GET', '/car');

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => ['*' => [
                'id',
                'type',
                'attributes' =>
                    [
                        'license',
                        'owner',
                        'color',
                        'model'
                    ]
            ]],
            'error',
            'status'
        ]);

    }

    public function testUpdate()
    {
        $data = factory(Car::class)->create();
        $response = $this->json('PUT', '/car/' . $data->id, [
            'model' => 'honada4',
            'owner' => 'Marcos Rubio',
            'type' => 'other'
        ]);

        $rData = json_decode($this->response->getContent());

        $this->assertNotEquals($rData->data->owner, $data->owner);

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
        $data = factory(Car::class)->create();
        $response = $this->json('DELETE', '/car/' . $data->id);


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
