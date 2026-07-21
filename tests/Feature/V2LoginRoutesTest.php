<?php

namespace Tests\Feature;

use Tests\TestCase;

class V2LoginRoutesTest extends TestCase
{
    public function test_v2_login_routes_do_not_shadow_fortify_login_routes(): void
    {
        $this->assertStringEndsWith('/v2/login', route('v2.login'));
        $this->assertStringEndsWith('/login', route('login'));
    }
}
