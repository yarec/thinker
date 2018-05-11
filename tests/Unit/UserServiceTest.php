<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Testing\HttpClientFake;
use Thinker\UCenter\Service\UserService;

class UserServiceTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
        $this->service = new UserService('token');
    }

    public function test_it_returns_a_user()
    {
        $this->clientFake
            ->mock('getUserById', ["user_id" => 123])
            ->applyClient();

        $result = $this->service->find(1);

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_username()
    {
        $this->clientFake
            ->mock('getUserByInfo', ["user_id" => 123])
            ->applyClient();

        $result = $this->service->findByName('name');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_phone()
    {
        $this->clientFake
            ->mock('getUserByInfo', ["user_id" => 123])
            ->applyClient();

        $result = $this->service->findByPhone('12345678901');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_username_and_phone()
    {
        $this->clientFake
            ->mock('getUserByInfo', ["user_id" => 123])
            ->applyClient();

        $result = $this->service->findByNameAndPhone('name', '12345678901');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_lists_users_in_a_domain()
    {
        $this->clientFake->mock('getUsersInDomain', ["users" => [
            "1001" => [
                "user_id" => 1001,
                "username" => "",
                "email" => "",
                "phone" => "",
                "details" => [
                    "realname" => [
                        "title" => "姓名",
                        "value" => "",
                    ],
                ],
            ],
        ]])->applyClient();

        $users = $this->service->listInDomain(1);

        $this->assertCount(1, $users);
    }

    public function test_it_register_a_new_user()
    {
        $this->clientFake
            ->mock('registerUser', ["user_id" => 123])
            ->applyClient();

        $user = $this->service->register('12345678901', '123456', 'name');

        $this->assertEquals(123, $user->user_id);
    }

    public function test_it_deletes_user_in_a_domain()
    {
        $this->clientFake
            ->mock('bindWechat', ['user_id' => 123])
            ->applyClient();

        $this->service->deleteInDomain(1, 1);
    }

    public function test_it_bind_wechat_to_user_account()
    {
        $this->clientFake
            ->mock('removeRoleForUser', ['user_id' => 123])
            ->applyClient();

        $response = $this->service->bindWechat('123456');

        $this->assertEquals(123, $response->user_id);
    }

    public function test_it_unbind_wechat_from_user_account()
    {
        $this->clientFake
            ->mock('unbindWechat', ['user_id' => 123])
            ->applyClient();

        $response = $this->service->unbindWechat('123456');

        $this->assertEquals(123, $response->user_id);
    }

}
