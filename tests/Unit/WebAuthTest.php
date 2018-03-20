<?php

namespace Tests\Unit;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\User;


class WebAuthTest extends TestCase
{

    private $webAuth;

    protected function setUp()
    {
        parent::setUp();

        $this->webAuth = UCenter::webAuth();
    }

    public function test_it_redirect_authorize_page()
    {
        $response = $this->webAuth->redirect();

        TestResponse::fromBaseResponse($response)
            ->assertRedirect(UCenterApi::urlOfAuthorizePage());
    }
    
    public function test_it_returns_user_info_if_authorized_code_is_valid()
    {
        UCenterApi::fake();

        $user = $this->webAuth->user($authorizedCode = '123456');

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

}
