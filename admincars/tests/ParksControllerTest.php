<?php

namespace App\Http\Controllers;

use App\Park;
use Faker\Factory as Faker;


class ParksControllerTest extends \TestCase
{

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/park', [
            'name' => $faker->word,
            'description' => $faker->word,

        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testList()
    {
        factory(Park::class,30)->create();
        $response = $this->json('GET', '/park');

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' => ['*' =>
                [
                    'id',
                    'type',
                    'attributes'

                ]
            ],
            'error',
            'status'
        ]);

    }
    public function testPark()
    {
        $park = factory(Park::class)->create();
        $response = $this->json('GET', '/park/'.$park->id);

        $response->assertResponseStatus(200);
        $this->seeJsonStructure([
            'message',
            'data' =>
                [
                    'id',
                    'type',
                    'attributes'

                ]
            ,
            'error',
            'status'
        ]);

    }


    public function testUpdate()
    {
        $data = factory(Park::class)->create();
        $response = $this->json('PUT', '/park/'.$data->id,[
            'name' => 'honada4',
            'description' => 'Marcos Rubio',
        ]);

        $rData = json_decode($this->response->getContent());

        $this->assertNotEquals($rData->data->name,$data->name);

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
        $data = factory(Park::class)->create();
        $response = $this->json('DELETE', '/park/'.$data->id);


        $response->assertResponseStatus(200);
        $rData = json_decode($this->response->getContent());
        $this->assertEquals($rData->data,null);
        $this->seeJsonStructure([
            'message',
            'data',
            'error',
            'status'
        ]);

    }
}
