<?php

namespace Tests\Feature;

use Tests\TestCase;

class IdentityRoutesTest extends TestCase
{
    public function test_login_page_is_available(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
