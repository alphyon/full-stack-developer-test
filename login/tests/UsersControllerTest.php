<?php

namespace App\Http\Controllers;

use App\User;
use Faker\Factory as Faker;


class UsersControllerTest extends \TestCase
{

    public function testCreate()
    {
        $faker = Faker::create();

        $response = $this->json('POST', '/register', [
          'name'=>'test',
          'password'=>'12345',
          'email'=>$faker->email,

        ]);

        $response->assertResponseStatus(201);
        $receive_json = json_decode($this->response->getContent());
        $this->assertTrue(isset($receive_json->data));
        $this->assertTrue(isset($receive_json->status));
        $this->assertTrue(isset($receive_json->message));


    }

    public function testList()
    {
        factory(User::class, 30)->create();
        $response = $this->json('GET', '/user');

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
        $data = factory(User::class)->create();
        $response = $this->json('PUT', '/user/' . $data->id, [
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
        $data = factory(User::class)->create();
        $response = $this->json('DELETE', '/user/' . $data->id);


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
