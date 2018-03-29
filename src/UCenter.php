<?php

namespace Thinker;

use Thinker\UCenter\Auth\ApiAuth;
use Thinker\UCenter\Auth\WebAuth;

class UCenter
{

    public function webAuth()
    {
        return new WebAuth();
    }

    public function apiAuth()
    {
        return new ApiAuth();
    }

}
